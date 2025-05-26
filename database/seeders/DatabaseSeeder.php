<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            TutorSeeder::class,
            EstudianteSeeder::class,
            GrupoSeeder::class, 
            AspectoSeeder::class,
            AsignacionAspectoSeeder::class, 
            AsistenciaSeeder::class,
        ]);
    }
}
