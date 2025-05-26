<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Aspecto;

class AspectoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $aspectos = [
            ['descripcion' => 'Participación en clase', 'tipo' => 'P'],
            ['descripcion' => 'Entrega puntual de tareas', 'tipo' => 'P'],
            ['descripcion' => 'Colaboración con compañeros', 'tipo' => 'P'],
            ['descripcion' => 'Falta injustificada', 'tipo' => 'G'],
            ['descripcion' => 'Interrupción en clase', 'tipo' => 'G'],
            ['descripcion' => 'No entrega de tareas', 'tipo' => 'G'],
            ['descripcion' => 'Ayuda a compañeros con dificultades', 'tipo' => 'L'],
            ['descripcion' => 'Muestra iniciativa en proyectos', 'tipo' => 'L'],
        ];

        foreach ($aspectos as $aspecto) {
            Aspecto::create($aspecto);
        }
    }
}
