<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el usuario administrador
        $admin = User::where('email', 'admin@callcenter.com')->first();

        if (!$admin) {
            $this->command->error('No se encontró el usuario administrador. Ejecuta primero UserSeeder.');
            return;
        }

        $courses = [
            [
                'title' => 'Inglés Básico',
                'description' => 'Curso de inglés básico para principiantes. Aprende vocabulario esencial, gramática fundamental y conversación básica.',
                'status' => 'published',
                'duration_minutes' => 1200, // 20 horas
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Inglés Intermedio',
                'description' => 'Curso de inglés intermedio para estudiantes con conocimientos básicos. Mejora tu fluidez y comprensión.',
                'status' => 'published',
                'duration_minutes' => 1500, // 25 horas
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Inglés Avanzado',
                'description' => 'Curso de inglés avanzado para estudiantes con nivel intermedio. Perfecciona tu dominio del idioma.',
                'status' => 'published',
                'duration_minutes' => 1800, // 30 horas
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Programación Web',
                'description' => 'Aprende desarrollo web con HTML, CSS, JavaScript y frameworks modernos. Ideal para iniciar una carrera en tecnología.',
                'status' => 'published',
                'duration_minutes' => 2400, // 40 horas
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Marketing Digital',
                'description' => 'Curso completo de marketing digital: SEO, SEM, redes sociales, email marketing y análisis de datos.',
                'status' => 'published',
                'duration_minutes' => 1800, // 30 horas
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Diseño Gráfico',
                'description' => 'Aprende diseño gráfico profesional con herramientas como Photoshop, Illustrator e InDesign.',
                'status' => 'published',
                'duration_minutes' => 2100, // 35 horas
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Contabilidad Básica',
                'description' => 'Fundamentos de contabilidad para pequeñas y medianas empresas. Aprende a llevar libros contables.',
                'status' => 'published',
                'duration_minutes' => 1500, // 25 horas
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Atención al Cliente',
                'description' => 'Desarrolla habilidades de atención al cliente, comunicación efectiva y resolución de problemas.',
                'status' => 'published',
                'duration_minutes' => 900, // 15 horas
                'created_by' => $admin->id,
            ],
        ];

        foreach ($courses as $courseData) {
            Course::create($courseData);
        }

        $this->command->info('Cursos creados exitosamente: ' . count($courses));
    }
}
