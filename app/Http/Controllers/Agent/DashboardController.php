<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\DemandeStage;
use App\Models\BesoinStage;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques globales pour tous les agents
        $stats = [
            'demandes_en_attente' => DemandeStage::where('statut', 'en_attente')->count(),

            'demandes_validees' => DemandeStage::where('statut', 'validee')->count(),

            'demandes_rejetees' => DemandeStage::where('statut', 'rejetee')->count(),

            'besoins' => BesoinStage::whereIn('statut', [
                'en_attente',
                'en_attente_validation'
            ])->count(),
        ];

        // Retour de la vue avec les stats
        return view('agent.dashboard', compact('stats'));
    }
}
