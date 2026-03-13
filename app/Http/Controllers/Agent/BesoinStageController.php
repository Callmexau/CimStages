<?php

namespace App\Http\Controllers;

use App\Models\BesoinStage;
use Illuminate\Http\Request;

class BesoinStageController extends Controller
{
    /**
     * Liste des besoins exprimés par les responsables
     */
    public function index(Request $request)
    {
        $query = BesoinStage::query();

        // 🔎 Recherche
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('service', 'like', '%' . $request->search . '%')
                  ->orWhere('profil_recherche', 'like', '%' . $request->search . '%')
                  ->orWhere('poste', 'like', '%' . $request->search . '%');
            });
        }

        // 📊 Filtre par statut
        if ($request->statut) {
            $query->where('statut', $request->statut);
        }

        // 🏢 Filtre par service
        if ($request->service) {
            $query->where('service', $request->service);
        }

        // 📄 Pagination
        $besoins = $query->latest()->paginate(10);

        // Liste des services pour le filtre
        $services = BesoinStage::select('service')->distinct()->pluck('service');

        return view('agent.besoins.index', compact('besoins', 'services'));
    }

    /**
     * Détail d’un besoin
     */
    public function show(BesoinStage $besoin)
    {
        return view('agent.besoins.show', compact('besoin'));
    }

    /**
     * Transférer un besoin au DARH
     */
    public function valider(BesoinStage $besoin)
    {
        $besoin->update([
            'statut' => 'transfere_agent'
        ]);

        if ($besoin->structure) {

            $responsable = $besoin->structure->responsable;

            foreach ($besoin->demandes as $demande) {

                $demande->update([
                    'responsable_id' => $responsable->id,
                    'statut' => 'transferee'
                ]);

            }
        }

        return back()->with('success', 'Besoin transféré au DARH avec succès.');
    }

    /**
     * Rejeter un besoin
     */
    public function rejeter(BesoinStage $besoin)
    {
        $besoin->update([
            'statut' => 'rejete'
        ]);

        return redirect()
            ->route('agent.besoins.show', $besoin->id)
            ->with('success', 'Expression de besoin rejetée avec succès.');
    }
}