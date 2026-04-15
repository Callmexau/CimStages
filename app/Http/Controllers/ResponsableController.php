<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use App\Models\DemandeStage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ResponsableController extends Controller
{
    // Page dashboard
    public function dashboard()
    {
        $responsableId = Auth::id();

        // Récupérer les demandes qui ne sont pas encore validées
        $demandes = DemandeStage::where('responsable_id', $responsableId)
            ->whereNotIn('statut', ['acceptee', 'termine'])
            ->latest()
            ->get();

        // Calculer les stagiaires en cours pour la carte stats
        $stagiairesEnCours = DemandeStage::where('statut', 'acceptee')
            ->where('structure_id', Auth::user()->structure_id)
            ->count();

        // Calculer les stagiaires terminés mais non évalués
        $stagiairesTerminesNonEvalues = DemandeStage::where('statut', 'termine')
            ->where('structure_id', Auth::user()->structure_id)
            ->whereDoesntHave('evaluation')
            ->count();

        return view('responsable.dashboard', compact(
            'demandes',
            'stagiairesEnCours',
            'stagiairesTerminesNonEvalues'
        ));
    }

    // Page menu des stagiaires
    public function index()
    {
        return view('responsable.stagiaires.index'); // juste le menu
    }

    public function show(DemandeStage $demande)
    {
        $demande->load('stagiaire'); // important

        return view('responsable.demande.show', compact('demande'));
    }

    // Valider une demande
    public function valider($id) // On utilise l'ID directement
    {
        // On récupère manuellement le modèle
        $demande = DemandeStage::findOrFail($id);

        // Sécurité : éviter double validation
        if ($demande->statut === 'acceptee') {
            return back()->with('error', 'Cette demande est déjà validée');
        }

        // Mettre à jour la demande
        $demande->update([
            'statut' => 'acceptee',
            'debut_stage' => now(),
            'fin_stage' => now()->addMonths(2),
        ]);

        return redirect()->route('responsable.dashboard')
                    ->with('success', 'Demande validée, stage de 2 mois approuvé');
    }

    // Rejeter une demande
    public function rejeter($id)
    {
        $demande = DemandeStage::findOrFail($id);

        $demande->statut = 'rejetee';
        $demande->save();

        return back()->with('success', 'Demande rejetée');
    }
    
    // Stagiaires en cours
    public function enCours(Request $request)
    {
        $responsable = auth()->user();
        $search = $request->input('search');

        $stagiairesEnCours = DemandeStage::where('statut', 'acceptee')
            ->where('structure_id', $responsable->structure_id)

            ->where(function ($query) {
                $query->where('fin_stage', '>', now())
                    ->orWhereNull('fin_stage'); // 🔥 FIX IMPORTANT
            })

            ->when($search, function ($query, $search) {
                $query->whereHas('stagiaire', function ($q) use ($search) {
                    $q->where('nom', 'ILIKE', "%$search%")
                    ->orWhere('prenom', 'ILIKE', "%$search%")
                    ->orWhere('email', 'ILIKE', "%$search%");
                });
            })

            ->with(['stagiaire', 'structure'])
            ->latest()
            ->paginate(10);

        return view('responsable.stagiaires.enCours', compact('stagiairesEnCours'));
    }

    // Stagiaires terminés
    public function termines()
    {
        $responsable = auth()->user();

        $stagiairesTermines = DemandeStage::with(['stagiaire', 'evaluation'])
            ->where('statut', 'termine')
            ->where('structure_id', $responsable->structure_id)
            ->latest()
            ->get();

        return view('responsable.stagiaires.termines', compact('stagiairesTermines'));
    }
    // Mettre fin à un stage
    public function terminerStage($id)
    {
        $demande = DemandeStage::findOrFail($id);

        $demande->update([
            'statut' => 'termine',
            'fin_stage' => now()
        ]);

        return back()->with('success', 'Stage terminé avec succès.');
    }
    }
