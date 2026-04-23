<?php

namespace App\Http\Controllers\Responsable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BesoinStage;
use App\Models\DemandeStage;
use App\Support\ActivityLogger;
use App\Support\NotificationRecipients;
use App\Notifications\BesoinCreeNotification;

class BesoinController extends Controller
{
    public function index()
    {
        $besoins = BesoinStage::latest()->get();

        return view('responsable.besoins.index', compact('besoins'));
    }

    public function create(Request $request)
    {
        $demande = null;

        if ($request->filled('demande')) {
            $demande = DemandeStage::with(['stagiaire', 'structure', 'evaluation'])
                ->find($request->demande);
        }

        return view('responsable.besoins.create', compact('demande'));
    }

    public function store(Request $request)
{
    $request->validate([
        'departement' => 'required|string|max:255',
        'poste' => 'required|string|max:255',
        'responsable_dept' => 'required|string|max:255',
        'fonction' => 'required|string|max:255',
        'date_requete' => 'required|date',
        'type_demande' => 'required|string|max:50',
        'service' => 'required|string|max:255',
        'encadrant' => 'required|string|max:255',
        'nombre_stagiaires' => 'required|integer|min:1',
        'duree' => 'nullable|string|max:100',
        'periode' => 'nullable|string|max:255',
        'domaine_formation' => 'nullable|string|max:255',
        'niveau_etudes' => 'nullable|string|max:255',
        'competences' => 'nullable|string',
        'motifs' => 'nullable|array',
        'autres_motifs' => 'nullable|string',
        'demande_stage_id' => 'nullable|exists:demande_stages,id',
    ]);

    $besoin = BesoinStage::create([
    'responsable_id'   => auth()->id(),
    'structure_id'     => auth()->user()->structure_id,
    'demande_stage_id' => $request->demande_stage_id,
    'departement'      => $request->departement,
    'poste'            => $request->poste,
    'responsable_nom'  => $request->responsable_dept,
    'fonction'         => $request->fonction,
    'date_requete'     => $request->date_requete,
    'type_demande'     => $request->type_demande,
    'motifs'           => $request->motifs,
    'autres_motifs'    => $request->autres_motifs,
    'service'          => $request->service,
    'encadrant'        => $request->encadrant,
    'nombre_stagiaires'=> $request->nombre_stagiaires,
    'duree'            => $request->duree,
    'periode'          => $request->periode,
    'domaine_formation'=> $request->domaine_formation,
    'niveau_etudes'    => $request->niveau_etudes,
    'competences'      => $request->competences,
    'statut'           => 'en_attente',
]);

ActivityLogger::log(
    'besoin_created',
    'Création d’un besoin de stage',
    'BesoinStage',
    $besoin->id,
    [
        'type_demande' => $besoin->type_demande,
        'service' => $besoin->service,
    ]
);

    foreach (NotificationRecipients::agents() as $agent) {
        if ($agent->email) {
            $agent->notify(new BesoinCreeNotification($besoin));
        }
    }
    
    return redirect()
        ->route('responsable.besoins.etat')
        ->with('success', 'Besoin transmis aux ressources humaines avec succès.');
}

    public function etat()
    {
        $besoin = BesoinStage::where('responsable_id', auth()->id())
            ->latest()
            ->first();

        return view('responsable.besoins.etat', compact('besoin'));
    }
}