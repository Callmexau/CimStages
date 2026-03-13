<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('structures', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // nom de la structure
            $table->string('abbreviation')->nullable(); // sigle optionnel
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Ajouter la colonne structure_id dans users
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('structure_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['structure_id']);
            $table->dropColumn('structure_id');
        });

        Schema::dropIfExists('structures');
    }
};
