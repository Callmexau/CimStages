<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('besoins_stages', function (Blueprint $table) {
            $table->boolean('is_seen_by_agent')->default(false)->after('statut');
            $table->foreignId('seen_by_agent_id')->nullable()->after('is_seen_by_agent')->constrained('users')->nullOnDelete();
            $table->timestamp('seen_at')->nullable()->after('seen_by_agent_id');
        });
    }

    public function down(): void
    {
        Schema::table('besoins_stages', function (Blueprint $table) {
            $table->dropConstrainedForeignId('seen_by_agent_id');
            $table->dropColumn(['is_seen_by_agent', 'seen_at']);
        });
    }
};