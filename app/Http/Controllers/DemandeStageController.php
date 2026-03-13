<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DemandeStage;
use App\Models\Structure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class DemandeStageController extends Controller
{
    public function create()
    {
        $structures = Structure::orderBy('name')->get();

        return view('stagiaire.demande.create', compact('structures'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'niveau_etude' => 'required|string|max:255',
            'filiere'      => 'required|string|max:255',
            'experience_professionnelle' => 'required|string|in:0 mois,2 mois,3 mois,4 mois,6 mois,1 an,2 ans,3 ans',
            'universite'   => 'required|string|max:255',
            'structure_id' => 'required|exists:structures,id',
            'telephone'    => 'required|string|max:30',
            'cv'   => 'required|file|mimes:pdf|max:5120',
            'cnib' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // Stocker les fichiers
        $cvPath = $request->file('cv')->store('uploads/cv', 'public');
        $cnibPath = $request->file('cnib')->store('uploads/cnib', 'public');

        // Créer la demande
        DemandeStage::create([
            'user_id'      => Auth::id(),
            'niveau_etude' => $request->niveau_etude,
            'filiere'      => $request->filiere,
            'experience_professionnelle' => $request->experience_professionnelle,
            'universite'   => $request->universite,
            'structure_id' => $request->structure_id,
            'telephone'    => $request->telephone,
            'cv_path'      => $cvPath,
            'cnib_path'    => $cnibPath,
            'statut'       => 'en_attente', // par défaut
        ]);

        return redirect()->route('stagiaire.demande.show')
                        ->with('success', 'Votre demande a été envoyée. Vous serez contacté par les Ressources Humaines.');
    }

    public function show()
    {
        $demande = DemandeStage::where('user_id', Auth::id())->latest()->first();

        return view('stagiaire.demande.show', compact('demande'));
    }

    public function index()
    {
        $demandes = DemandeStage::with('stagiaire')
            ->latest()
            ->get();

        return view('agent.demandes.index', compact('demandes'));
    }
    

}
