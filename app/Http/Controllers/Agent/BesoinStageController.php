<?php

namespace App\Http\Controllers\Agent;

use App\Models\BesoinStage;
use Illuminate\Http\Request;
use App\Models\DemandeStage;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Support\ActivityLogger;
use App\Support\NotificationRecipients;
use App\Notifications\BesoinTransmisNotification;
use App\Notifications\StageRenouvelleNotification;

class BesoinStageController extends Controller
{
    /**
     * Liste des besoins exprimés par les responsables
     */
    public function index(Request $request)
    {
        $baseQuery = BesoinStage::query()
            ->with(['responsable', 'seenByAgent']);

        if ($request->filled('search')) {
            $search = $request->search;

            $baseQuery->where(function ($q) use ($search) {
                $q->where('service', 'like', '%' . $search . '%')
                  ->orWhere('profil_recherche', 'like', '%' . $search . '%')
                  ->orWhere('poste', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('service')) {
            $baseQuery->where('service', $request->service);
        }

        if ($request->filled('statut')) {
            $baseQuery->where('statut', $request->statut);
        }

        $besoinsEnAttente = (clone $baseQuery)
            ->where('statut', 'en_attente')
            ->latest()
            ->paginate(10, ['*'], 'pending_page')
            ->appends($request->query());

        $besoinsValides = (clone $baseQuery)
            ->where('statut', 'valide')
            ->orderByRaw('CASE WHEN is_seen_by_agent = false OR is_seen_by_agent IS NULL THEN 0 ELSE 1 END')
            ->orderByDesc('updated_at')
            ->paginate(10, ['*'], 'validated_page')
            ->appends($request->query());

        $services = BesoinStage::query()
            ->select('service')
            ->whereNotNull('service')
            ->distinct()
            ->orderBy('service')
            ->pluck('service');

        $countEnAttente = (clone $baseQuery)
            ->where('statut', 'en_attente')
            ->count();

        $countValides = (clone $baseQuery)
            ->where('statut', 'valide')
            ->count();

        $countValidesNonConsultes = (clone $baseQuery)
            ->where('statut', 'valide')
            ->where(function ($q) {
                $q->where('is_seen_by_agent', false)
                  ->orWhereNull('is_seen_by_agent');
            })
            ->count();

        $countValidesConsultes = (clone $baseQuery)
            ->where('statut', 'valide')
            ->where('is_seen_by_agent', true)
            ->count();

        return view('agent.besoins.index', compact(
            'besoinsEnAttente',
            'besoinsValides',
            'services',
            'countEnAttente',
            'countValides',
            'countValidesNonConsultes',
            'countValidesConsultes'
        ));
    }

    /**
     * Détail d’un besoin
     */
    public function show(BesoinStage $besoin)
    {
        if ($besoin->statut === 'valide' && !$besoin->is_seen_by_agent) {
            $besoin->update([
                'is_seen_by_agent' => true,
                'seen_by_agent_id' => auth()->id(),
                'seen_at' => now(),
            ]);
        }

        $besoin->load(['responsable', 'demandeStage', 'seenByAgent']);

        return view('agent.besoins.show', compact('besoin'));
    }

    /**
     * Transférer un besoin au DARH
     */
    public function valider(BesoinStage $besoin)
    {
        $ancienStatut = $besoin->statut;

        $besoin->update([
            'statut' => 'en_attente_validation'
        ]);

        $besoin->load(['responsable']);

        ActivityLogger::log(
            'besoin_transferred',
            "Transfert du besoin #{$besoin->id} au DARH",
            'BesoinStage',
            $besoin->id,
            [
                'ancien_statut' => $ancienStatut,
                'nouveau_statut' => $besoin->statut,
                'responsable_id' => $besoin->responsable_id,
                'type_demande' => $besoin->type_demande,
                'service' => $besoin->service,
                'agent_id' => auth()->id(),
            ]
        );

        foreach (NotificationRecipients::darhs() as $darh) {
            if ($darh->email) {
                $darh->notify(new BesoinTransmisNotification($besoin));
            }
        }

        return back()->with('success', 'Besoin transféré au DARH avec succès.');
    }

    /**
     * Rejeter un besoin
     */
    public function rejeter(BesoinStage $besoin)
    {
        $ancienStatut = $besoin->statut;

        $besoin->update([
            'statut' => 'rejete'
        ]);

        ActivityLogger::log(
            'besoin_rejected_by_agent',
            "Rejet du besoin #{$besoin->id} par l'agent",
            'BesoinStage',
            $besoin->id,
            [
                'ancien_statut' => $ancienStatut,
                'nouveau_statut' => 'rejete',
                'responsable_id' => $besoin->responsable_id,
                'type_demande' => $besoin->type_demande,
                'service' => $besoin->service,
                'agent_id' => auth()->id(),
            ]
        );

        return redirect()
            ->route('agent.besoins.show', $besoin->id)
            ->with('success', 'Expression de besoin rejetée avec succès.');
    }

    public function demandesLiees(BesoinStage $besoin)
    {
        $demandes = DemandeStage::where('statut', 'en_attente')
            ->latest()
            ->get();

        return view('agent.besoins.demandes', compact('besoin', 'demandes'));
    }

    public function renouvelerStage(BesoinStage $besoin)
    {
        if (strtolower($besoin->type_demande) !== 'renouvellement') {
            return back()->with('error', 'Ce besoin ne correspond pas à un renouvellement.');
        }

        if (!$besoin->demande_stage_id) {
            return back()->with('error', 'Aucun stage source n’est lié à ce besoin.');
        }

        $demande = DemandeStage::with(['stagiaire', 'responsable'])->find($besoin->demande_stage_id);

        if (!$demande) {
            return back()->with('error', 'Le stage à renouveler est introuvable.');
        }

        $baseDate = $demande->fin_stage
            ? Carbon::parse($demande->fin_stage)
            : now();

        $nouvelleFin = match ($besoin->duree) {
            '1 mois' => $baseDate->copy()->addMonth(),
            '2 mois' => $baseDate->copy()->addMonths(2),
            '3 mois' => $baseDate->copy()->addMonths(3),
            default => $baseDate->copy()->addMonth(),
        };

        $demande->update([
            'fin_stage' => $nouvelleFin,
            'statut' => 'acceptee',
        ]);

        $besoin->update([
            'statut' => 'traite',
        ]);

        ActivityLogger::log(
            'stage_renewed',
            "Renouvellement du stage lié à la demande #{$demande->id}",
            'DemandeStage',
            $demande->id,
            [
                'besoin_id' => $besoin->id,
                'ancienne_fin_stage' => $baseDate->toDateTimeString(),
                'nouvelle_fin_stage' => $nouvelleFin->toDateTimeString(),
                'type_demande' => $besoin->type_demande,
                'responsable_id' => $demande->responsable_id,
                'stagiaire_id' => $demande->user_id,
                'agent_id' => auth()->id(),
            ]
        );

        if ($demande->responsable && $demande->responsable->email) {
            $demande->responsable->notify(new StageRenouvelleNotification($demande));
        }

        if ($demande->stagiaire && $demande->stagiaire->email) {
            $demande->stagiaire->notify(new StageRenouvelleNotification($demande));
        }

        return back()->with('success', 'Le stage a été renouvelé avec succès.');
    }
}