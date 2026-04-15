<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('besoins_stages', function (Blueprint $table) {
            $table->foreignId('demande_stage_id')
                ->nullable()
                ->after('structure_id')
                ->constrained('demande_stages')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('besoins_stages', function (Blueprint $table) {
            $table->dropConstrainedForeignId('demande_stage_id');
        });
    }
};