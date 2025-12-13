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
        $driver = DB::getDriverName();
        
        if ($driver === 'mysql') {
            // MySQL: Modificar el ENUM para incluir 'trabajador'
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'operator', 'trabajador') DEFAULT 'operator'");
        } else {
            // PostgreSQL: Agregar restricción CHECK
            DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");
            DB::statement("
                ALTER TABLE users 
                ADD CONSTRAINT users_role_check 
                CHECK (role IN ('admin', 'operator', 'trabajador'))
            ");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();
        
        // Cambiar los trabajadores a operator
        DB::table('users')->where('role', 'trabajador')->update(['role' => 'operator']);
        
        if ($driver === 'mysql') {
            // MySQL: Revertir el ENUM
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'operator') DEFAULT 'operator'");
        } else {
            // PostgreSQL: Eliminar la restricción
            DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");
        }
    }
};
