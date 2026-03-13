<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('demande_stages', function (Blueprint $table) {

            // Ajouter uniquement si la colonne n'existe pas
            if (!Schema::hasColumn('demande_stages', 'universite')) {
                $table->string('universite')->nullable()->after('filiere');
            }

            if (!Schema::hasColumn('demande_stages', 'structure_id')) {
                $table->foreignId('structure_id')
                    ->nullable()
                    ->after('telephone')
                    ->constrained('structures')
                    ->cascadeOnDelete();
            }

        });
    }

    public function down(): void
    {
        Schema::table('demande_stages', function (Blueprint $table) {
            if (Schema::hasColumn('demande_stages', 'structure_id')) {
                $table->dropForeign(['structure_id']);
                $table->dropColumn('structure_id');
            }

            if (Schema::hasColumn('demande_stages', 'universite')) {
                $table->dropColumn('universite');
            }
        });
    }
};
