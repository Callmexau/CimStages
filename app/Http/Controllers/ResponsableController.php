<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use App\Models\DemandeStage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Support\ActivityLogger;
use App\Notifications\DemandeValideeNotification;
use App\Notifications\DemandeRejeteeNotification;

class ResponsableController extends Controller
{
    // Page dashboard
    public function dashboard()
    {
        $responsableId = Auth::id();

        $demandes = DemandeStage::where('responsable_id', $responsableId)
            ->whereNotIn('statut', ['acceptee', 'termine'])
            ->latest()
            ->get();

        $stagiairesEnCours = DemandeStage::where('statut', 'acceptee')
            ->where('structure_id', Auth::user()->structure_id)
            ->count();

        $stagiairesTerminesNonEvalues = DemandeStage::where('statut', 'termine')
            ->where('structure_id', Auth::user()->structure_id)
            ->whereDoesntHave('evaluation')
            ->count();

        return view('responsable.dashboard', compact(
            'demandes',
            'stagiairesEnCours',
            'stagiairesTerminesNonEvalues'
        ));
    }

    // Page menu des stagiaires
    public function index()
    {
        return view('responsable.stagiaires.index');
    }

    public function show(DemandeStage $demande)
    {
        $demande->load('stagiaire');

        return view('responsable.demande.show', compact('demande'));
    }

    // Valider une demande
    public function valider($id)
    {
        $demande = DemandeStage::findOrFail($id);

        if ($demande->statut === 'acceptee') {
            return back()->with('error', 'Cette demande est déjà validée');
        }

        $demande->update([
            'statut' => 'acceptee',
            'debut_stage' => now(),
            'fin_stage' => now()->addMonths(2),
        ]);

        $demande->load('stagiaire');

        ActivityLogger::log(
            'demande_validated',
            "Validation de la demande de stage #{$demande->id}",
            'DemandeStage',
            $demande->id,
            [
                'stagiaire_id' => $demande->user_id,
                'structure_id' => $demande->structure_id,
                'responsable_id' => auth()->id(),
                'debut_stage' => optional($demande->debut_stage)?->toDateTimeString(),
                'fin_stage' => optional($demande->fin_stage)?->toDateTimeString(),
            ]
        );

        if ($demande->stagiaire && $demande->stagiaire->email) {
            $demande->stagiaire->notify(new DemandeValideeNotification($demande));
        }

        return redirect()->route('responsable.dashboard')
            ->with('success', 'Demande validée, stage de 2 mois approuvé');
    }

    // Rejeter une demande
    public function rejeter($id)
    {
        $demande = DemandeStage::findOrFail($id);

        $ancienStatut = $demande->statut;

        $demande->update([
            'statut' => 'rejetee',
        ]);

        $demande->load('stagiaire');

        ActivityLogger::log(
            'demande_rejected',
            "Rejet de la demande de stage #{$demande->id}",
            'DemandeStage',
            $demande->id,
            [
                'ancien_statut' => $ancienStatut,
                'nouveau_statut' => 'rejetee',
                'stagiaire_id' => $demande->user_id,
                'structure_id' => $demande->structure_id,
                'responsable_id' => auth()->id(),
            ]
        );

        if ($demande->stagiaire && $demande->stagiaire->email) {
            $demande->stagiaire->notify(new DemandeRejeteeNotification($demande));
        }

        return back()->with('success', 'Demande rejetée');
    }

    // Stagiaires en cours
    public function enCours(Request $request)
    {
        $responsable = auth()->user();
        $search = $request->input('search');

        $stagiairesEnCours = DemandeStage::where('statut', 'acceptee')
            ->where('structure_id', $responsable->structure_id)
            ->where(function ($query) {
                $query->where('fin_stage', '>', now())
                    ->orWhereNull('fin_stage');
            })
            ->when($search, function ($query, $search) {
                $query->whereHas('stagiaire', function ($q) use ($search) {
                    $q->where('nom', 'ILIKE', "%$search%")
                        ->orWhere('prenom', 'ILIKE', "%$search%")
                        ->orWhere('email', 'ILIKE', "%$search%");
                });
            })
            ->with(['stagiaire', 'structure'])
            ->latest()
            ->paginate(10);

        return view('responsable.stagiaires.enCours', compact('stagiairesEnCours'));
    }

    // Stagiaires terminés
    public function termines()
    {
        $responsable = auth()->user();

        $stagiairesTermines = DemandeStage::with(['stagiaire', 'evaluation'])
            ->where('statut', 'termine')
            ->where('structure_id', $responsable->structure_id)
            ->latest()
            ->get();

        return view('responsable.stagiaires.termines', compact('stagiairesTermines'));
    }

    // Mettre fin à un stage
    public function terminerStage($id)
    {
        $demande = DemandeStage::findOrFail($id);

        $ancienStatut = $demande->statut;
        $ancienneFinStage = $demande->fin_stage;

        $demande->update([
            'statut' => 'termine',
            'fin_stage' => now(),
        ]);

        ActivityLogger::log(
            'stage_ended',
            "Fin du stage pour la demande #{$demande->id}",
            'DemandeStage',
            $demande->id,
            [
                'ancien_statut' => $ancienStatut,
                'nouveau_statut' => 'termine',
                'ancienne_fin_stage' => $ancienneFinStage ? \Carbon\Carbon::parse($ancienneFinStage)->toDateTimeString() : null,
                'nouvelle_fin_stage' => optional($demande->fin_stage)?->toDateTimeString(),
                'stagiaire_id' => $demande->user_id,
                'structure_id' => $demande->structure_id,
                'responsable_id' => auth()->id(),
            ]
        );

        return back()->with('success', 'Stage terminé avec succès.');
    }
}