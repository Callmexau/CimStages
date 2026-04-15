<?php

namespace App\Http\Controllers;

use App\Models\DemandeStage;
use App\Models\Evaluation;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function create($id)
    {
        $demande = DemandeStage::with(['stagiaire', 'structure', 'evaluation'])->findOrFail($id);

        return view('responsable.evaluations.create', compact('demande'));
    }

    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'demande_id'     => 'required|exists:demande_stages,id',
            'poste'          => 'nullable|string|max:255',
            'scores'         => 'required|array',
            'commentaires'   => 'nullable|string|max:1000',
            'recommandation' => 'nullable|string|max:255',
            'note_finale'    => 'required|numeric|min:0|max:20',
        ]);

        // Vérifier si une évaluation existe déjà pour cette demande
        $evaluationExistante = Evaluation::where('demande_id', $request->demande_id)->first();

        if ($evaluationExistante) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Cette demande a déjà été évaluée.');
        }

        // Création de l’évaluation
        Evaluation::create([
            'demande_id'     => $request->demande_id,
            'poste'          => $request->poste,
            'scores'         => $request->scores,
            'commentaires'   => $request->commentaires,
            'recommandation' => $request->recommandation,
            'note_finale'    => $request->note_finale,
        ]);


        return redirect()
            ->route('responsable.evaluations.create', $request->demande_id)
            ->with('success', 'Évaluation enregistrée avec succès ✅');
    }
}