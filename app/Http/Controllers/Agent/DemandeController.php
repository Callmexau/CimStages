<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\DemandeStage;
use App\Models\User;
use Illuminate\Http\Request;

class DemandeController extends Controller
{
    public function index(Request $request)
    {
        $query = DemandeStage::with(['stagiaire', 'responsable'])
            ->where('is_renewal', false) // on garde ici seulement les demandes normales
            ->where('statut', '!=', 'acceptee')
            ->orderBy('created_at', 'desc');

        // Sans recherche : afficher seulement les demandes non orientées
        if (!$request->filled('search')) {
            $query->where('statut', 'en_attente');
        }

        // Avec recherche : on autorise aussi les dossiers déjà orientés
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->whereHas('stagiaire', function ($sq) use ($search) {
                    $sq->where('nom', 'ilike', "%{$search}%")
                        ->orWhere('prenom', 'ilike', "%{$search}%")
                        ->orWhere('email', 'ilike', "%{$search}%");
                })
                ->orWhere('filiere', 'ilike', "%{$search}%")
                ->orWhere('niveau_etude', 'ilike', "%{$search}%")
                ->orWhere('universite', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('experience')) {
            $query->where('experience_professionnelle', 'ilike', "%{$request->experience}%");
        }

        if ($request->filled('structure_id')) {
            $query->where('structure_id', $request->structure_id);
        }

        if ($request->filled('structure')) {
            $query->where('structure_id', $request->structure);
        }

        if ($request->filled('besoin')) {
            $query->where('besoin_stage_id', $request->besoin);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('universite')) {
            $query->where('universite', 'ilike', "%{$request->universite}%");
        }

        $demandes = $query->get();

        $responsables = User::whereHas('role', function ($q) {
            $q->where('name', 'responsable');
        })->get();

        return view('agent.demande.index', compact('demandes', 'responsables'));
    }

    public function transfer(Request $request, DemandeStage $demande)
    {
        $request->validate([
            'responsable_id' => 'required|exists:users,id',
        ]);

        $demande->responsable_id = $request->responsable_id;
        $demande->statut = 'transferée';
        $demande->save();

        return back()->with('success', 'Demande transférée avec succès au responsable.');
    }

    public function renew(DemandeStage $demande)
    {
        if (!$demande->is_renewal) {
            return back()->with('error', 'Ce dossier n’est pas un renouvellement.');
        }

        if (empty($demande->responsable_id)) {
            return back()->with('error', 'Aucun responsable n’est associé à ce dossier.');
        }

        if ($demande->statut !== 'termine' && $demande->statut !== 'transferée') {
            return back()->with('error', 'Ce dossier ne peut pas être renouvelé dans son état actuel.');
        }

        $demande->debut_stage = now();
        $demande->fin_stage = now()->copy()->addMonths(2);
        $demande->statut = 'acceptee';
        $demande->save();

        return back()->with('success', 'Le stage a été renouvelé avec succès.');
    }

    public function stagiairesEnCours(Request $request)
    {
        $query = DemandeStage::with(['stagiaire', 'structure', 'responsable'])
            ->where('statut', 'acceptee')
            ->where(function ($q) {
                $q->whereNull('fin_stage')
                  ->orWhere('fin_stage', '>=', now());
            });

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('stagiaire', function ($q) use ($search) {
                $q->where('nom', 'ilike', "%{$search}%")
                  ->orWhere('prenom', 'ilike', "%{$search}%");
            });
        }

        $stagiairesEnCours = $query->latest()->paginate(10);

        return view('agent.demande.stagiaires', compact('stagiairesEnCours'));
    }

    public function show(DemandeStage $demande)
    {
        $demande->load(['stagiaire', 'structure', 'responsable', 'evaluation']);

        return view('agent.demande.show', compact('demande'));
    }
}