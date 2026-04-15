<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('demande_stages', function (Blueprint $table) {
            $table->boolean('is_renewal')->default(false)->after('type_stage');
            $table->unsignedBigInteger('parent_id')->nullable()->after('is_renewal');

            $table->foreign('parent_id')
                ->references('id')
                ->on('demande_stages')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('demande_stages', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['is_renewal', 'parent_id']);
        });
    }
};