<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('voters', function (Blueprint $table) {
            $table->enum('consulta_status', ['pending', 'processing', 'completed', 'failed'])->default('pending')->after('estado');
            $table->text('consulta_error')->nullable()->after('consulta_status');
            $table->timestamp('consulta_completed_at')->nullable()->after('consulta_error');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('voters', function (Blueprint $table) {
            $table->dropColumn(['consulta_status', 'consulta_error', 'consulta_completed_at']);
        });
    }
};
