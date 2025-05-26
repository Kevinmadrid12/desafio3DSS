<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Estudiante;
use Illuminate\Support\Str;

class EstudianteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $estudiantes = [
            [
                'codigo' => 'EST-' . Str::random(5),
                'nombres' => 'Ana Sofia',
                'apellidos' => 'Martinez Lopez',
                'dui' => '87654321-0',
                'email' => 'ana.martinez@example.com',
                'telefono' => '6666-5555',
                'fecha_nacimiento' => '2000-08-20',
                'fotografia' => null, 
                'estado' => 'activo'
            ],
        ];

        foreach ($estudiantes as $estudiante) {
            Estudiante::create($estudiante);
        }

        Estudiante::factory(20)->create();
    }
    
}
