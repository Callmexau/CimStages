<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\DemandeStage;
use App\Models\Structure;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function index(Request $request)
    {
        $query = DemandeStage::with(['stagiaire', 'structure', 'evaluation'])
            ->where('statut', 'termine')
            ->orderByDesc('fin_stage');

        // Recherche textuelle
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('stagiaire', function ($sub) use ($search) {
                    $sub->where('nom', 'ilike', "%{$search}%")
                        ->orWhere('prenom', 'ilike', "%{$search}%")
                        ->orWhere('email', 'ilike', "%{$search}%");
                })
                ->orWhere('universite', 'ilike', "%{$search}%");
            });
        }

        // Filtre université
        if ($request->filled('universite')) {
            $query->where('universite', $request->universite);
        }

        // Filtre structure
        if ($request->filled('structure_id')) {
            $query->where('structure_id', $request->structure_id);
        }

        // Filtre dates
        if ($request->filled('date_debut')) {
            $query->whereDate('fin_stage', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->whereDate('fin_stage', '<=', $request->date_fin);
        }

        // Filtre présence de note
        if ($request->filled('etat_note')) {
            if ($request->etat_note === 'avec_note') {
                $query->whereHas('evaluation', function ($q) {
                    $q->whereNotNull('note_finale');
                });
            }

            if ($request->etat_note === 'sans_note') {
                $query->where(function ($q) {
                    $q->whereDoesntHave('evaluation')
                      ->orWhereHas('evaluation', function ($sub) {
                          $sub->whereNull('note_finale');
                      });
                });
            }
        }

        // Filtre par tranche de note
        if ($request->filled('note')) {
            $query->whereHas('evaluation', function ($q) use ($request) {
                switch ($request->note) {
                    case 'excellent':
                        $q->whereBetween('note_finale', [16, 20]);
                        break;

                    case 'tres_bien':
                        $q->where('note_finale', '>=', 14)
                          ->where('note_finale', '<', 16);
                        break;

                    case 'bien':
                        $q->where('note_finale', '>=', 12)
                          ->where('note_finale', '<', 14);
                        break;

                    case 'passable':
                        $q->where('note_finale', '>=', 10)
                          ->where('note_finale', '<', 12);
                        break;

                    case 'insuffisant':
                        $q->where('note_finale', '<', 10);
                        break;
                }
            });
        }

        $archives = $query->paginate(12)->withQueryString();

        $universites = DemandeStage::where('statut', 'termine')
            ->whereNotNull('universite')
            ->distinct()
            ->orderBy('universite')
            ->pluck('universite');

        $structures = Structure::orderBy('name')->get();

        return view('agent.archives.index', compact('archives', 'universites', 'structures'));
    }
}