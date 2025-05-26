<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Asistencia;
use App\Models\Estudiante;
use App\Models\Tutor;
use Carbon\Carbon;

class AsistenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $estudiantes = Estudiante::all();
        $tutores = Tutor::all();
        $tiposAsistencia = ['A', 'I', 'J'];

        if ($estudiantes->isEmpty() || $tutores->isEmpty()) {
            $this->command->info('No hay suficientes estudiantes o tutores para registrar asistencias. Ejecuta EstudianteSeeder y TutorSeeder primero.');
            return;
        }

        // Crear 100 registros de asistencia de ejemplo
        for ($i = 0; $i < 100; $i++) {
            Asistencia::create([
                'fecha' => Carbon::now()->subDays(rand(0, 60))->format('Y-m-d'),
                'codigo_estudiante' => $estudiantes->random()->codigo,
                'codigo_tutor' => $tutores->random()->codigo, 
                'tipo' => $tiposAsistencia[array_rand($tiposAsistencia)],
            ]);
        }
    }
}
