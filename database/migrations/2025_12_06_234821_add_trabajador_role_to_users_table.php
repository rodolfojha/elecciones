<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modificar el enum para incluir 'trabajador'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'operator', 'trabajador') DEFAULT 'operator'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir a los valores originales
        // Primero cambiar los trabajadores a operator
        DB::table('users')->where('role', 'trabajador')->update(['role' => 'operator']);
        
        // Luego modificar el enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'operator') DEFAULT 'operator'");
    }
};
