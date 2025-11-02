<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            [
                'first_name' => 'Carlos',
                'last_name' => 'Rodríguez',
                'phone' => '+1 555-0101',
                'email' => 'carlos.rodriguez@example.com',
                'address' => 'Calle Principal 123',
                'city' => 'Ciudad de México',
                'state' => 'CDMX',
                'status' => 'waiting',
            ],
            [
                'first_name' => 'María',
                'last_name' => 'González',
                'phone' => '+1 555-0102',
                'email' => 'maria.gonzalez@example.com',
                'address' => 'Avenida Reforma 456',
                'city' => 'Guadalajara',
                'state' => 'Jalisco',
                'status' => 'waiting',
            ],
            [
                'first_name' => 'José',
                'last_name' => 'Martínez',
                'phone' => '+1 555-0103',
                'email' => 'jose.martinez@example.com',
                'address' => 'Boulevard Juárez 789',
                'city' => 'Monterrey',
                'state' => 'Nuevo León',
                'status' => 'waiting',
            ],
            [
                'first_name' => 'Ana',
                'last_name' => 'López',
                'phone' => '+1 555-0104',
                'email' => 'ana.lopez@example.com',
                'address' => 'Calle Hidalgo 321',
                'city' => 'Puebla',
                'state' => 'Puebla',
                'status' => 'waiting',
            ],
            [
                'first_name' => 'Luis',
                'last_name' => 'Hernández',
                'phone' => '+1 555-0105',
                'email' => 'luis.hernandez@example.com',
                'address' => 'Avenida Universidad 654',
                'city' => 'Querétaro',
                'state' => 'Querétaro',
                'status' => 'waiting',
            ],
            [
                'first_name' => 'Carmen',
                'last_name' => 'Sánchez',
                'phone' => '+1 555-0106',
                'email' => 'carmen.sanchez@example.com',
                'address' => 'Calle Morelos 987',
                'city' => 'Tijuana',
                'state' => 'Baja California',
                'status' => 'waiting',
            ],
            [
                'first_name' => 'Pedro',
                'last_name' => 'Ramírez',
                'phone' => '+1 555-0107',
                'email' => 'pedro.ramirez@example.com',
                'address' => 'Boulevard Zapata 147',
                'city' => 'Mérida',
                'state' => 'Yucatán',
                'status' => 'waiting',
            ],
            [
                'first_name' => 'Laura',
                'last_name' => 'Torres',
                'phone' => '+1 555-0108',
                'email' => 'laura.torres@example.com',
                'address' => 'Avenida Insurgentes 258',
                'city' => 'León',
                'state' => 'Guanajuato',
                'status' => 'waiting',
            ],
        ];

        foreach ($clients as $clientData) {
            Client::create($clientData);
        }
    }
}

