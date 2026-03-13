<?php

namespace App\Http\Controllers\Darh;

use App\Http\Controllers\Controller;
use App\Models\BesoinStage;
use Illuminate\Http\Request;

class BesoinsController extends Controller
{
    // Affiche tous les besoins transférés par les agents
    public function index()
    {
        $besoins = BesoinStage::whereIn('statut', ['en_attente_validation','en_attente','transfere'])
                    ->orderBy('date_requete', 'desc')
                    ->get();

        return view('darh.besoins.index', compact('besoins'));
    }

    // Valider un besoin
    public function valider(BesoinStage $besoin)
    {
        $besoin->update([
            'statut' => 'valide'
        ]);

        return redirect()
            ->route('darh.dashboard')
            ->with('success', 'Besoin validé avec succès.');
    }

    // Rejeter un besoin
    public function rejeter(BesoinStage $besoin)
    {
        $besoin->update([
            'statut' => 'rejete'
        ]);

        return redirect()
            ->route('darh.dashboard')
            ->with('error', 'Besoin rejeté.');
    }

    // Afficher les détails d'un besoin
    public function show(BesoinStage $besoin)
    {
        return view('darh.besoins.show', compact('besoin'));
    }
}