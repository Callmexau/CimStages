<?php

namespace App\Http\Controllers\Darh;

use App\Http\Controllers\Controller;
use App\Models\BesoinStage;
use Illuminate\Http\Request;
use App\Support\ActivityLogger;
use App\Notifications\BesoinValideNotification;
use App\Notifications\BesoinRejeteNotification;
use App\Notifications\BesoinRenouvellementValideNotification;

class BesoinsController extends Controller
{
    // Affiche tous les besoins transférés par les agents
    public function index()
    {
        $besoins = BesoinStage::whereIn('statut', ['en_attente_validation', 'en_attente', 'transfere'])
            ->orderBy('date_requete', 'desc')
            ->get();

        return view('darh.besoins.index', compact('besoins'));
    }

    // Valider un besoin
    public function valider(BesoinStage $besoin)
    {
        $ancienStatut = $besoin->statut;

        $besoin->update([
            'statut' => 'valide'
        ]);

        $besoin->load('responsable');

        ActivityLogger::log(
            'besoin_validated',
            "Validation du besoin #{$besoin->id}",
            'BesoinStage',
            $besoin->id,
            [
                'ancien_statut' => $ancienStatut,
                'nouveau_statut' => 'valide',
                'responsable_id' => $besoin->responsable_id,
                'type_demande' => $besoin->type_demande,
                'service' => $besoin->service,
                'darh_id' => auth()->id(),
            ]
        );

        if ($besoin->responsable && $besoin->responsable->email) {
            if (strtolower($besoin->type_demande) === 'renouvellement') {
                $besoin->responsable->notify(
                    new BesoinRenouvellementValideNotification($besoin)
                );
            } else {
                $besoin->responsable->notify(
                    new BesoinValideNotification($besoin)
                );
            }
        }

        return redirect()
            ->route('darh.dashboard')
            ->with('success', 'Besoin validé avec succès.');
    }

    // Rejeter un besoin
    public function rejeter(BesoinStage $besoin)
    {
        $ancienStatut = $besoin->statut;

        $besoin->update([
            'statut' => 'rejete'
        ]);

        $besoin->load('responsable');

        ActivityLogger::log(
            'besoin_rejected',
            "Rejet du besoin #{$besoin->id}",
            'BesoinStage',
            $besoin->id,
            [
                'ancien_statut' => $ancienStatut,
                'nouveau_statut' => 'rejete',
                'responsable_id' => $besoin->responsable_id,
                'type_demande' => $besoin->type_demande,
                'service' => $besoin->service,
                'darh_id' => auth()->id(),
            ]
        );

        if ($besoin->responsable && $besoin->responsable->email) {
            $besoin->responsable->notify(
                new BesoinRejeteNotification($besoin)
            );
        }

        return redirect()
            ->route('darh.dashboard')
            ->with('error', 'Besoin rejeté.');
    }

    // Afficher les détails d'un besoin
    public function show(BesoinStage $besoin)
    {
        $besoin->load('responsable');

        return view('darh.besoins.show', compact('besoin'));
    }
}