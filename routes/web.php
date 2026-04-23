<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminStructureController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Agent\DashboardController as AgentDashboard;
use App\Http\Controllers\Responsable\BesoinController;
use App\Http\Controllers\EvaluationStageController;
use App\Http\Controllers\Agent\DemandeController;
use App\Http\Controllers\Darh\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResponsableController;
use App\Models\BesoinStage;
use App\Http\Controllers\Darh\BesoinsController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\Responsable\RenouvellementController;
use App\Http\Controllers\Agent\BesoinStageController;
use App\Http\Controllers\Admin\ActivityLogController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('/a-propos', 'about')->name('about');


/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/

// Connexion
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.store');

// Inscription
Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.store');

// Déconnexion
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Dashboard générique
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profil (auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/changer-mot-de-passe', function () {
        return view('auth.force-password-change');
    })->name('password.change');

    Route::post('/changer-mot-de-passe', function (\Illuminate\Http\Request $request) {

        $request->validate([
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = auth()->user();
        $user->password = bcrypt($request->password);
        $user->must_change_password = false;
        $user->save();

        return redirect()->route(match ($user->role->name) {
            'admin' => 'admin.users.index',
            'agent' => 'agent.dashboard',
            'responsable' => 'responsable.dashboard',
            'darh' => 'darh.dashboard',
            default => 'stagiaire.dashboard',
        });

    })->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Administrateur
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
        Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        Route::post('/users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])
            ->name('users.reset-password');

        Route::resource('structures', AdminStructureController::class);

        Route::get('/logs', [ActivityLogController::class, 'index'])
            ->name('logs.index');
    });

/*
|--------------------------------------------------------------------------
| Stagiaire
|--------------------------------------------------------------------------
*/
Route::prefix('stagiaire')
    ->name('stagiaire.')
    ->middleware(['auth', 'role:stagiaire'])
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('stagiaire.dashboard');
        })->name('dashboard');

        Route::get('/demande/create', [App\Http\Controllers\DemandeStageController::class, 'create'])
            ->name('demande.create');

        Route::post('/demande', [App\Http\Controllers\DemandeStageController::class, 'store'])
            ->name('demande.store');

        Route::get('/demande', [App\Http\Controllers\DemandeStageController::class, 'show'])
            ->name('demande.show');

    });

/*
|--------------------------------------------------------------------------
| Agent RH
|--------------------------------------------------------------------------
*/
Route::prefix('agent')
    ->name('agent.')
    ->middleware(['auth', 'role:agent', 'force.password'])
    ->group(function () {

        Route::get('/dashboard', [AgentDashboard::class, 'index'])
            ->name('dashboard');

        Route::get('/demandes', [DemandeController::class, 'index'])
            ->name('demande.index');

        // LISTE DES BESOINS
        Route::get('/besoins', [BesoinStageController::class, 'index'])
            ->name('besoins.index');

        // DÉTAILS D’UN BESOIN
        Route::get('/besoins/{besoin}', [BesoinStageController::class, 'show'])
            ->name('besoins.show');

        // TRANSFÉRER UN BESOIN AU DARH
        Route::post('/besoins/{besoin}/transfer', [BesoinStageController::class, 'valider'])
            ->name('besoins.transfer');

        // REJETER UN BESOIN
        Route::post('/besoins/{besoin}/rejeter', [BesoinStageController::class, 'rejeter'])
            ->name('besoins.rejeter');

        // DEMANDES LIÉES À UN BESOIN
        Route::get('/besoins/{besoin}/demandes', [BesoinStageController::class, 'demandesLiees'])
            ->name('besoins.demandes');

        // PDF
        Route::get('/besoins/{besoin}/pdf', function (\App\Models\BesoinStage $besoin) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('agent.besoins.pdf', compact('besoin'));

            return $pdf->download('besoin_stage_' . $besoin->id . '.pdf');
        })->name('besoins.pdf');

        // STAGIAIRES EN COURS
        Route::get('/stagiaires-en-cours', [DemandeController::class, 'stagiairesEnCours'])
            ->name('stagiaires.encours');

        // TRANSFERT D’UNE DEMANDE À UN RESPONSABLE
        Route::post('/demandes/{demande}/transfer', [DemandeController::class, 'transfer'])
            ->name('demande.transfer');

        // RENOUVELER UNE DEMANDE (ancienne logique)
        Route::post('/demandes/{demande}/renew', [DemandeController::class, 'renew'])
            ->name('demande.renew');

        // RENOUVELER UN STAGE À PARTIR D’UN BESOIN VALIDÉ
        Route::post('/besoins/{besoin}/renouveler-stage', [BesoinStageController::class, 'renouvelerStage'])
            ->name('besoins.renouvelerStage');

        // ARCHIVES
        Route::get('/archives', [\App\Http\Controllers\Agent\ArchiveController::class, 'index'])
            ->name('archives.index');

        // DÉTAIL D’UNE DEMANDE
        Route::get('/demandes/{demande}', [DemandeController::class, 'show'])
            ->name('demande.show');
    });

    
/*
|--------------------------------------------------------------------------
| Responsable
|--------------------------------------------------------------------------
*/
Route::prefix('responsable')
    ->name('responsable.')
    ->middleware(['auth', 'role:responsable', 'force.password'])
    ->group(function () {

        Route::get('/dashboard', [ResponsableController::class, 'dashboard'])
            ->name('dashboard');

        // Menu principal
        Route::get('/stagiaires', [ResponsableController::class, 'index'])
            ->name('stagiaires.index');

        // Stagiaires en cours
        Route::get('/stagiaires/en-cours', [ResponsableController::class, 'enCours'])
            ->name('stagiaires.enCours');

        // Dossier stagiaire
        Route::get('/demande/{demande}', [ResponsableController::class, 'show'])
            ->name('demande.show');
        
        Route::post('/demande/{demande}/valider', [ResponsableController::class, 'valider'])
            ->name('demande.valider');

        Route::post('/demande/{demande}/rejeter', [ResponsableController::class, 'rejeter'])
            ->name('demande.rejeter');

        // Stagiaires terminés
        Route::get('/stagiaires/termines', [ResponsableController::class, 'termines'])
            ->name('stagiaires.termines');

        // Liste des besoins
        Route::get('/besoins', [BesoinController::class, 'index'])
            ->name('besoins.index');
        
        Route::get('/besoins/etat', [BesoinController::class, 'etat'])
            ->name('besoins.etat');

        // Formulaire création
        Route::get('/besoins/create', [BesoinController::class, 'create'])
            ->name('besoins.create');

        // Enregistrement
        Route::post('/besoins', [BesoinController::class, 'store'])
            ->name('besoins.store');

        // Annuler le stage
        Route::patch('/stages/{id}/terminer', [ResponsableController::class, 'terminerStage'])
            ->name('stages.terminer');

         // Évaluations
        Route::get('/evaluations/create/{demande}', [EvaluationController::class, 'create'])
            ->name('evaluations.create');

        Route::post('/evaluations', [EvaluationController::class, 'store'])
            ->name('evaluations.store');

        // Renouvellement de stage
        Route::get('/stages/{demande}/renouveler', [RenouvellementController::class, 'create'])
            ->name('renouvellement.create');

        Route::post('/stages/{demande}/renouveler', [RenouvellementController::class, 'store'])
            ->name('renouvellement.store');
    });




/*
|--------------------------------------------------------------------------
| DARH
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:darh', 'force.password'])
    ->prefix('darh')
    ->name('darh.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Liste des besoins transférés par les agents
        Route::get('/besoins', [BesoinsController::class, 'index'])->name('besoins.index');

        // Voir les détails d’un besoin
        Route::get('/besoins/{besoin}', [BesoinsController::class, 'show'])->name('besoins.show');

        // Valider un besoin
        Route::post('/besoins/{besoin}/valider', [BesoinsController::class, 'valider'])->name('besoins.valider');

        // Rejeter un besoin
        Route::post('/besoins/{besoin}/rejeter', [BesoinsController::class, 'rejeter'])->name('besoins.rejeter');
});
