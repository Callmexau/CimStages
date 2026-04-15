<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('demande_stages', function (Blueprint $table) {
            $table->timestamp('debut_stage')->nullable()->after('statut');
            $table->timestamp('fin_stage')->nullable()->after('debut_stage');
        });
    }

    public function down(): void
    {
        Schema::table('demande_stages', function (Blueprint $table) {
            $table->dropColumn(['debut_stage', 'fin_stage']);
        });
    }
};