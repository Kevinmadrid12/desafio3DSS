<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Grupo;
use App\Models\Tutor;
use App\Models\Estudiante;

class GrupoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tutores = Tutor::all();
        $estudiantes = Estudiante::all();

        if ($tutores->isEmpty() || $estudiantes->isEmpty()) {
            $this->command->info('No hay suficientes tutores o estudiantes para crear grupos. Ejecuta TutorSeeder y EstudianteSeeder primero.');
            return;
        }

        Grupo::factory()->count(5)->make()->each(function ($grupo) use ($tutores, $estudiantes) {
            // Asignar un tutor aleatorio
            $grupo->codigo_tutor = $tutores->random()->codigo;
            $grupo->save();

            // Asignar entre 5 y 10 estudiantes aleatorios al grupo
            $estudiantesDelGrupo = $estudiantes->random(rand(5, min(10, $estudiantes->count())));
            $grupo->estudiantes()->attach($estudiantesDelGrupo->pluck('codigo'));
        });
    }
}
