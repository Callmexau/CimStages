<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1️⃣ Seed les rôles
        $roles = ['admin', 'agent', 'responsable', 'darh', 'stagiaire'];
        foreach ($roles as $r) {
            \App\Models\Role::firstOrCreate(['name' => $r]);
        }

        // 2️⃣ Récupérer le rôle admin
        $adminRole = Role::where('name', 'admin')->first();

        // 3️⃣ Créer le Super Admin
        User::firstOrCreate(
            ['email' => 'admin@cimburkina.com'],
            [
                'name' => 'Super Admin',
                'email' => 'admin@cimburkina.com',
                'password' => Hash::make('password123'),
                'role_id' => $adminRole->id,
                'sexe' => 'M',
                'date_naissance' => '1990-01-01',
                'is_active' => true,
                'must_change_password' => false,
            ]
        );
    }
}
