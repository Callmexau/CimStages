<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Supprimer l’ancienne contrainte
        DB::statement("
            ALTER TABLE users 
            DROP CONSTRAINT IF EXISTS users_role_check
        ");

        // Recréer la contrainte avec DARH
        DB::statement("
            ALTER TABLE users 
            ADD CONSTRAINT users_role_check 
            CHECK (role IN ('admin','darh','agent','responsable','stagiaire'))
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE users 
            DROP CONSTRAINT IF EXISTS users_role_check
        ");

        DB::statement("
            ALTER TABLE users 
            ADD CONSTRAINT users_role_check 
            CHECK (role IN ('admin','agent','responsable','stagiaire'))
        ");
    }
};

