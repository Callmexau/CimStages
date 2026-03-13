<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\DemandeStage;
use App\Models\User; // responsables
use Illuminate\Http\Request;

class DemandeController extends Controller
{
    public function index(Request $request)
    {
        $query = DemandeStage::with('stagiaire')->orderBy('created_at', 'desc');

        // Filtre de recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('stagiaire', function ($q) use ($search) {
                $q->where('nom', 'ilike', "%{$search}%")
                ->orWhere('prenom', 'ilike', "%{$search}%")
                ->orWhere('email', 'ilike', "%{$search}%");
            })->orWhere('filiere', 'ilike', "%{$search}%")
            ->orWhere('niveau_etude', 'ilike', "%{$search}%")
            ->orWhere('universite', 'ilike', "%{$search}%");
        }

        // Filtre expérience
        if ($request->filled('experience')) {
            $query->where('experience_professionnelle', 'ilike', "%{$request->experience}%");
        }


        // Filtre structure
        if ($request->filled('structure_id')) {
            $query->where('structure_id', $request->structure_id);
        }

        // Filtre université spécifique
        if ($request->filled('universite')) {
            $query->where('universite', 'ilike', "%{$request->universite}%");
        }


        $demandes = $query->get();

        // Récupérer tous les responsables pour le transfert
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

        // On peut stocker le transfert dans la demande (champ responsable_id)
        $demande->responsable_id = $request->responsable_id;
        $demande->statut = 'transferée';
        $demande->save();

        return back()->with('success', 'Demande transférée avec succès au responsable.');
    }
}
