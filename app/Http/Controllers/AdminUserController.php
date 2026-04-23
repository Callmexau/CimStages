<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Structure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Support\ActivityLogger;

class AdminUserController extends Controller
{
    // 1️⃣ Liste des utilisateurs internes
    public function index()
    {
        $users = User::with('role')
            ->whereHas('role', function ($query) {
                $query->where('name', '!=', 'stagiaire');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.users.index', compact('users'));
    }

    // 2️⃣ Formulaire de création
    public function create()
    {
        $roles = Role::orderBy('name')->get();
        $structures = Structure::orderBy('name')->get();

        return view('admin.users.create', compact('roles', 'structures'));
    }

    // 3️⃣ Stockage d’un nouvel utilisateur
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role_id' => 'required|exists:roles,id',
            'sexe' => 'required|in:M,F',
            'structure_id' => 'nullable|exists:structures,id',
        ]);

        $tempPassword = Str::random(10);

        $user = User::create([
            'name' => $request->prenom . ' ' . $request->nom,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'sexe' => $request->sexe,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'structure_id' => $request->structure_id,
            'password' => Hash::make($tempPassword),
            'must_change_password' => true,
            'is_active' => true,
        ]);

        ActivityLogger::log(
            'user_created',
            "Création de l'utilisateur {$user->email}",
            'User',
            $user->id,
            [
                'role_id' => $user->role_id,
                'structure_id' => $user->structure_id,
            ]
        );

        return redirect()->route('admin.users.index')
            ->with('success', "Utilisateur créé. Mot de passe temporaire : $tempPassword");
    }

    // 4️⃣ Formulaire d’édition
    public function edit(User $user)
    {
        $roles = Role::orderBy('name')->get();
        $structures = Structure::orderBy('name')->get();

        return view('admin.users.edit', compact('user', 'roles', 'structures'));
    }

    // 5️⃣ Mise à jour
    public function update(Request $request, User $user)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'structure_id' => 'nullable|exists:structures,id',
            'is_active' => 'required|boolean',
        ]);

        $before = [
            'nom' => $user->nom,
            'prenom' => $user->prenom,
            'email' => $user->email,
            'role_id' => $user->role_id,
            'structure_id' => $user->structure_id,
            'is_active' => $user->is_active,
        ];

        $user->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'name' => $request->prenom . ' ' . $request->nom,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'structure_id' => $request->structure_id,
            'is_active' => $request->is_active,
        ]);

        ActivityLogger::log(
            'user_updated',
            "Modification de l'utilisateur {$user->email}",
            'User',
            $user->id,
            [
                'before' => $before,
                'after' => [
                    'nom' => $user->nom,
                    'prenom' => $user->prenom,
                    'email' => $user->email,
                    'role_id' => $user->role_id,
                    'structure_id' => $user->structure_id,
                    'is_active' => $user->is_active,
                ],
            ]
        );

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    // 6️⃣ Désactivation
    public function destroy(User $user)
    {
        $before = [
            'email' => $user->email,
            'role_id' => $user->role_id,
            'structure_id' => $user->structure_id,
            'is_active' => $user->is_active,
        ];

        $user->update([
            'is_active' => false,
        ]);

        ActivityLogger::log(
            'user_deleted',
            "Désactivation de l'utilisateur {$user->email}",
            'User',
            $user->id,
            [
                'before' => $before,
                'after' => [
                    'is_active' => $user->is_active,
                ],
            ]
        );

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur désactivé.');
    }

    public function resetPassword(User $user)
    {
        $tempPassword = Str::random(10);

        $user->update([
            'password' => Hash::make($tempPassword),
            'must_change_password' => true,
        ]);

        ActivityLogger::log(
            'user_password_reset',
            "Réinitialisation du mot de passe de {$user->email}",
            'User',
            $user->id,
            [
                'role_id' => $user->role_id,
                'structure_id' => $user->structure_id,
            ]
        );

        return redirect()->route('admin.users.index')
            ->with('success', "Mot de passe temporaire pour {$user->nom} {$user->prenom} : $tempPassword");
    }
}