<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Structure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    // Appliquer le middleware admin
 //   public function __construct()
   // {
     //   $this->middleware('auth');
       // $this->middleware('role:admin'); // on créera ce middleware après
    //}

    // 1️⃣ Liste des utilisateurs internes
    public function index()
{
    $users = User::with('role')
                 ->whereHas('role', function($query) {
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

        return view('admin.users.create', compact('roles'));
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
        ]);

        // Générer un mot de passe temporaire aléatoire
        $tempPassword = \Str::random(10);

        User::create([
            'name' => $request->prenom . ' ' . $request->nom,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'sexe' => $request->sexe,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'structure_id' => $request->structure_id,
            'password' => Hash::make($tempPassword),
            'must_change_password' => true,
        ]);

        return redirect()->route('admin.users.index')
                        ->with('success', "Utilisateur créé. Mot de passe temporaire : $tempPassword");
    }

    // 4️⃣ Formulaire d’édition
    public function edit(User $user)
    {
        $roles = Role::orderBy('name')->get();

        return view('admin.users.edit', compact('user', 'roles'));
    }


    // 5️⃣ Mise à jour
    public function update(Request $request, User $user)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'is_active' => 'required|boolean',
        ]);

        $user->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }


    // 6️⃣ Désactivation / suppression
    public function destroy(User $user)
    {
        // On ne supprime pas, on désactive
        $user->update(['is_active' => false]);

        return redirect()->route('admin.users.index')
                        ->with('success', 'Utilisateur désactivé.');
    }

    public function resetPassword(User $user)
    {
        // Générer mot de passe temporaire aléatoire
        $tempPassword = Str::random(10);

        // Mettre à jour l'utilisateur
        $user->update([
            'password' => Hash::make($tempPassword),
            'must_change_password' => true,
        ]);

        // Retour avec message
        return redirect()->route('admin.users.index')
                        ->with('success', "Mot de passe temporaire pour {$user->nom} {$user->prenom} : $tempPassword");
    }

}
