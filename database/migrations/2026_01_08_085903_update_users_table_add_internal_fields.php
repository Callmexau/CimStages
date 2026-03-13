<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Séparer le nom complet
            $table->string('nom')->nullable()->after('id');
            $table->string('prenom')->nullable()->after('nom');

            // Métier
            $table->date('date_naissance')->nullable()->after('email');
            $table->enum('role', [
                'admin',
                'agent',
                'responsable',
                'stagiaire'
            ])->default('stagiaire')->after('password');

            $table->boolean('is_active')->default(true)->after('role');

            // Sécurité
            $table->boolean('must_change_password')
                  ->default(false)
                  ->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nom',
                'prenom',
                'date_naissance',
                'role',
                'is_active',
                'must_change_password',
            ]);
        });
    }
};

