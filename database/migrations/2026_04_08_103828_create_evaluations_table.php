<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('demande_id')
                    ->constrained('demande_stages')
                    ->cascadeOnDelete();

            $table->string('poste')->nullable();
            $table->json('scores');
            $table->text('commentaires')->nullable();
            $table->string('recommandation')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};