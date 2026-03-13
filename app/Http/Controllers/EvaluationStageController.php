<?php

namespace App\Http\Controllers;

use App\Models\EvaluationStage;
use Illuminate\Http\Request;

class EvaluationStageController extends Controller
{
    /**
     * Afficher le formulaire d’évaluation
     */
    public function create()
    {
        return view('evaluations.create');
    }

    /**
     * Enregistrer l’évaluation
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom_stagiaire'   => 'required|string|max:255',
            'service'         => 'required|string|max:255',
            'fonction'        => 'nullable|string|max:255',
            'periode'         => 'required|string|max:255',
            'date_evaluation' => 'required|date',
            'eval'            => 'required|array',
            'commentaires'    => 'nullable|string',
            'recommandation'  => 'required|string',
        ]);

        EvaluationStage::create([
            'stagiaire_id'    => null, // on liera plus tard au vrai stagiaire
            'responsable_id'  => null, // idem
            'service'         => $request->service,
            'fonction'        => $request->fonction,
            'periode'         => $request->periode,
            'evaluations'     => $request->eval,
            'commentaires'    => $request->commentaires,
            'recommandation'  => $request->recommandation,
            'date_evaluation' => $request->date_evaluation,
        ]);

        return redirect()->back()->with('success', 'Évaluation enregistrée avec succès');
    }
}
