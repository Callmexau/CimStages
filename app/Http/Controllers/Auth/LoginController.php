<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Affiche le formulaire de login
     */
    public function show()
    {
        return view('auth.login');
    }

    /**
     * Traite la connexion de l'utilisateur
     */
    public function login(Request $request)
    {
        // Validation des champs
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tentative de connexion
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Utilisation de role_name pour éviter les erreurs si role_id = null
            $roleName = $user->role?->name;

            switch ($roleName) {
                case 'stagiaire':
                    return redirect()->route('stagiaire.dashboard');

                case 'agent':
                    return redirect()->route('agent.dashboard');

                case 'responsable':
                    return redirect()->route('responsable.dashboard');

                case 'admin':
                    return redirect()->route('admin.users.index');

                case 'darh':
                    return redirect()->route('darh.dashboard');

                default:
                    return redirect()->route('dashboard');
            }
        }

        // Si la connexion échoue
        return back()->withErrors([
            'email' => 'Identifiants incorrects.',
        ])->withInput();
    }

    /**
     * Déconnexion de l'utilisateur
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
