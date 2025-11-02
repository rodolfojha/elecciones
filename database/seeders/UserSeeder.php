<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear o actualizar usuario administrador
        User::updateOrCreate(
            ['email' => 'admin@callcenter.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Crear o actualizar usuario operador
        User::updateOrCreate(
            ['email' => 'operador@callcenter.com'],
            [
                'name' => 'Operador CallCenter',
                'password' => Hash::make('operador123'),
                'role' => 'operator',
                'email_verified_at' => now(),
            ]
        );

        // Crear o actualizar operador adicional
        User::updateOrCreate(
            ['email' => 'juan@callcenter.com'],
            [
                'name' => 'Juan Pérez',
                'password' => Hash::make('operador123'),
                'role' => 'operator',
                'email_verified_at' => now(),
            ]
        );
    }
}

