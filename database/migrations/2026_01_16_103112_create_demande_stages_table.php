<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('demande_stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // stagiaire
            $table->string('niveau_etude');
            $table->string('filiere');
            $table->string('cv_path');   // chemin du fichier CV
            $table->string('cnib_path'); // chemin de la CNIB
            $table->string('statut')->default('en_attente'); // en_attente / accepte / refuse
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('demande_stages');
    }
};
