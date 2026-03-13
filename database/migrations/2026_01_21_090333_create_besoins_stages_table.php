<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('besoins_stages', function (Blueprint $table) {
            $table->id();

            // Responsable (temporairement nullable)
            $table->foreignId('responsable_id')->nullable()->constrained('users')->nullOnDelete();

            // Structure concernée
            $table->foreignId('structure_id')->nullable()->constrained()->nullOnDelete();

            $table->string('poste');
            $table->integer('nombre_stagiaires');
            $table->text('missions');
            $table->date('date_debut_souhaitee')->nullable();
            $table->date('date_fin_souhaitee')->nullable();

            $table->string('statut')->default('en_attente'); 
            // en_attente | validé | rejeté

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('besoins_stages');
    }
};
