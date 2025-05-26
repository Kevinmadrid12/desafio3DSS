<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tutor;
use Illuminate\Support\Str;

class TutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $tutores = [
            [
                'codigo' => 'TUT-' . Str::random(5),
                'nombres' => 'Carlos Alberto',
                'apellidos' => 'Rivera Gomez',
                'dui' => '02968418-4',
                'email' => 'carlos.rivera@example.com',
                'telefono' => '7777-8888',
                'fecha_nacimiento' => '1985-05-15',
                'fecha_contratacion' => '2020-01-10',
                'estado' => 'contratado'
            ],
        ];

        foreach ($tutores as $tutor) {
            Tutor::create($tutor);
        }

        Tutor::factory(5)->create();
    }
}
