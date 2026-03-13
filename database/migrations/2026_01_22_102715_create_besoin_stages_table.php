<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('besoin_stages', function (Blueprint $table) {
            $table->id();

            // Demandeur
            $table->string('departement');
            $table->string('responsable_nom');
            $table->string('fonction');
            $table->date('date_requete');

            // Type & motifs
            $table->string('type_demande');
            $table->json('motifs')->nullable();
            $table->text('autres_motifs')->nullable();

            // Affectation
            $table->string('service');
            $table->string('encadrant');

            // Profil recherché
            $table->string('domaine_formation')->nullable();
            $table->string('niveau_etudes')->nullable();
            $table->text('competences')->nullable();

            // Stage
            $table->string('duree')->nullable();
            $table->integer('nombre_stagiaires');
            $table->string('periode')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('besoin_stages');
    }
};
