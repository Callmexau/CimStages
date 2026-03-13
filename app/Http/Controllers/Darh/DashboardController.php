<?php

namespace App\Http\Controllers\Darh;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BesoinStage;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),

            'stagiaires' => BesoinStage::where('statut', 'valide')->sum('nombre_stagiaires'),

            'responsables' => User::whereHas('role', fn($q) => $q->where('name', 'responsable'))->count(),

            'agents' => User::whereHas('role', fn($q) => $q->where('name', 'agent'))->count(),
        ];

        $besoins = BesoinStage::whereIn('statut', ['en_attente_validation', 'en_attente', 'transfere_agent'])
                        ->orderBy('date_requete', 'desc')
                        ->get();

        return view('darh.dashboard', compact('stats', 'besoins'));
    }

    public function show(BesoinStage $besoin)
    {
        return view('darh.besoins.show', compact('besoin'));
    }
}