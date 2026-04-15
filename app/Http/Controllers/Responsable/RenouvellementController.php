<?php

namespace App\Http\Controllers\Responsable;

use App\Http\Controllers\Controller;
use App\Models\DemandeStage;
use App\Models\BesoinStage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RenouvellementController extends Controller
{
    public function create(DemandeStage $demande)
    {
        $demande->load(['stagiaire', 'structure']);

        return view('responsable.renouvellements.create', compact('demande'));
    }

    public function store(Request $request, DemandeStage $demande)
    {
        $request->validate([
            'poste' => ['required', 'string', 'max:255'],
            'service' => ['required', 'string', 'max:255'],
            'encadrant' => ['required', 'string', 'max:255'],
            'duree' => ['required', 'string', 'max:100'],
            'periode' => ['required', 'string', 'max:255'],
            'motif_renouvellement' => ['required', 'string'],
        ]);

        $responsable = Auth::user();

        BesoinStage::create([
            'responsable_id'    => $responsable->id,
            'structure_id'      => $demande->structure_id,
            'demande_stage_id'  => $demande->id,
            'departement'       => $responsable->structure->name ?? 'Non défini',
            'poste'             => $request->poste,
            'responsable_nom'   => trim(($responsable->prenom ?? '') . ' ' . ($responsable->nom ?? '')),
            'fonction'          => 'Responsable',
            'date_requete'      => now()->toDateString(),
            'type_demande'      => 'renouvellement',
            'motifs'            => ['Renouvellement de stage'],
            'autres_motifs'     => $request->motif_renouvellement,
            'service'           => $request->service,
            'encadrant'         => $request->encadrant,
            'domaine_formation' => $demande->filiere,
            'niveau_etudes'     => $demande->niveau_etude,
            'competences'       => $demande->experience_professionnelle ?? 'RAS',
            'duree'             => $request->duree,
            'nombre_stagiaires' => 1,
            'periode'           => $request->periode,
            'statut'            => 'en_attente_validation',
            'demandeur_nom'     => trim(($responsable->prenom ?? '') . ' ' . ($responsable->nom ?? '')),
        ]);

        return redirect()
            ->route('responsable.stagiaires.enCours')
            ->with('success', 'La demande de renouvellement a été soumise avec succès.');
    }
}