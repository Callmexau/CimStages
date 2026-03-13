<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'sexe' => 'required|in:Masculin,Féminin',
            'date_naissance' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    if (Carbon::parse($value)->age < 21) {
                        $fail('Vous devez avoir au moins 21 ans pour vous inscrire.');
                    }
                },
            ],
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // ✅ Récupérer le rôle stagiaire
        $stagiaireRole = Role::where('name', 'stagiaire')->firstOrFail();

        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'name' => $request->prenom . ' ' . $request->nom,
            'sexe' => $request->sexe,
            'email' => $request->email,
            'date_naissance' => $request->date_naissance,
            'password' => Hash::make($request->password),
            'role_id' => $stagiaireRole->id,
            'must_change_password' => false,
        ]);

        Auth::login($user);

        return redirect()->route('stagiaire.dashboard')
                        ->with('success', 'Inscription réussie. Bienvenue !');
    }
}
