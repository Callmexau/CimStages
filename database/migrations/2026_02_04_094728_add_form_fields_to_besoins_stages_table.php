<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('besoins_stages', function (Blueprint $table) {

            // Informations demandeur
            $table->string('departement')->nullable();
            $table->string('responsable_nom')->nullable();
            $table->string('fonction')->nullable();
            $table->date('date_requete')->nullable();

            // Type & motifs
            $table->string('type_demande')->nullable();
            $table->json('motifs')->nullable();
            $table->text('autres_motifs')->nullable();

            // Affectation
            $table->string('service')->nullable();
            $table->string('encadrant')->nullable();

            // Profil stagiaire
            $table->string('domaine_formation')->nullable();
            $table->string('niveau_etudes')->nullable();
            $table->text('competences')->nullable();

            // Stage
            $table->string('duree')->nullable();
            // nombre_stagiaires existe déjà chez toi → on ne le touche pas
            $table->string('periode')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('besoins_stages', function (Blueprint $table) {
            $table->dropColumn([
                'departement',
                'responsable_nom',
                'fonction',
                'date_requete',
                'type_demande',
                'motifs',
                'autres_motifs',
                'service',
                'encadrant',
                'domaine_formation',
                'niveau_etudes',
                'competences',
                'duree',
                'periode',
            ]);
        });
    }
};
