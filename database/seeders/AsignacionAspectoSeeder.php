<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AsignacionAspecto;
use App\Models\Aspecto;
use App\Models\Estudiante;
use App\Models\Tutor;
use Carbon\Carbon;

class AsignacionAspectoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $aspectos = Aspecto::all();
        $estudiantes = Estudiante::all();
        $tutores = Tutor::all();

        if ($aspectos->isEmpty() || $estudiantes->isEmpty() || $tutores->isEmpty()) {
            $this->command->info('No hay suficientes aspectos, estudiantes o tutores para crear asignaciones. Ejecuta los seeders correspondientes primero.');
            return;
        }

        // Crear 50 asignaciones de aspectos de ejemplo
        for ($i = 0; $i < 50; $i++) {
            AsignacionAspecto::create([
                'aspecto_id' => $aspectos->random()->id,
                'fecha' => Carbon::now()->subDays(rand(0, 30))->format('Y-m-d'),
                'codigo_estudiante' => $estudiantes->random()->codigo,
                'codigo_tutor' => $tutores->random()->codigo,
            ]);
        }
    }
}
