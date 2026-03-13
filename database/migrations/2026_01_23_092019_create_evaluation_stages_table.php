<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('evaluation_stages', function (Blueprint $table) {
    $table->id();

    // Identifiants (sans contraintes pour l'instant)
    $table->unsignedBigInteger('stagiaire_id');
    $table->unsignedBigInteger('responsable_id');

    // Contexte du stage
    $table->string('service');
    $table->string('fonction')->nullable();
    $table->string('periode');

    // Canevas d’évaluation
    $table->json('evaluations');
    $table->text('commentaires')->nullable();
    $table->string('recommandation')->nullable();

    $table->date('date_evaluation')->default(now());

    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('evaluation_stages');
    }
};
