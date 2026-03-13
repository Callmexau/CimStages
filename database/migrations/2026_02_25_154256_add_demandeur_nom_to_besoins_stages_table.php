<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('besoins_stages', function (Blueprint $table) {
        $table->string('demandeur_nom')->nullable();
    });
}

public function down()
{
    Schema::table('besoins_stages', function (Blueprint $table) {
        $table->dropColumn('demandeur_nom');
    });
}
};
