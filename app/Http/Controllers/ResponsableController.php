<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DemandeStage;
use Illuminate\Support\Facades\Auth;

class ResponsableController extends Controller
{
    // Page dashboard
    public function dashboard()
    {
        $responsableId = Auth::id();

    $demandes = DemandeStage::where('structure_id', auth()->user()->structure_id)
                        ->where('statut', 'validée')
                        ->latest()
                        ->get();

    return view('responsable.dashboard', compact('demandes'));

    }

    // Page menu des stagiaires
    public function index()
    {
        return view('responsable.stagiaires.index'); // juste le menu
    }

    // Stagiaires en cours
    public function enCours()
    {
        $responsable = auth()->user();

        $stagiairesEnCours = User::whereHas('role', function ($query) {
                $query->where('name', 'stagiaire');
            })
            ->where('structure_id', $responsable->structure_id)
            ->where('statut', 'accepte')
            ->where('fin_stage', '>', now())
            ->get();

        return view('responsable.stagiaires.enCours', compact('stagiairesEnCours'));
    }

    // Stagiaires terminés
    public function termines()
    {
        $responsable = auth()->user();

        $stagiairesTermines = User::whereHas('role', function ($query) {
                $query->where('name', 'stagiaire');
            })
            ->where('structure_id', $responsable->structure_id)
            ->where('statut', 'accepte')
            ->where('fin_stage', '<=', now())
            ->get();

        return view('responsable.stagiaires.termines', compact('stagiairesTermines'));
    }
}
