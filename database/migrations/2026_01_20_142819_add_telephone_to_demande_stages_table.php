<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('demande_stages', function (Blueprint $table) {
            $table->string('telephone', 20)->after('filiere');
        });
    }

    public function down(): void
    {
        Schema::table('demande_stages', function (Blueprint $table) {
            $table->dropColumn('telephone');
        });
    }
};
