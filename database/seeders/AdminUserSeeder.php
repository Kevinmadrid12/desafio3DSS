<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents; 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // --- Usuario Administrador ---
        $adminPassword = 'Admin123!'; // Contraseña para el administrador
        $hashedAdminPassword = Hash::make($adminPassword);

        // Verificación de integridad para la contraseña del admin
        if (!Hash::check($adminPassword, $hashedAdminPassword)) {
            throw new \RuntimeException("Error generando el hash para la contraseña del admin.");
        }

        DB::table('users')->updateOrInsert(
            ['email' => 'admin@academia.edu'], 
            [
                'name' => 'Administrador',
                'password' => $hashedAdminPassword,
                'role' => 'admin',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
        $this->command->info('Usuario Administrador creado/actualizado: admin@academia.edu | Pass: Admin123!');

        // --- Usuario Tutor de Ejemplo ---
        $tutorPassword = 'tutorejemplo123'; 
        $hashedTutorPassword = Hash::make($tutorPassword);

        if (!Hash::check($tutorPassword, $hashedTutorPassword)) {
            throw new \RuntimeException("Error generando el hash para la contraseña del tutor de ejemplo.");
        }

        DB::table('users')->updateOrInsert(
            ['email' => 'tutor.ejemplo@academia.edu'], 
            [
                'name' => 'Jose Mario',      
                'password' => $hashedTutorPassword,
                'role' => 'tutor',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
        $this->command->info('Usuario Jose Mario creado/actualizado: tutor.ejemplo@academia.edu | Pass: tutorejemplo123');

        // --- Usuario Estudiante de Ejemplo ---
        $studentPassword = 'estudianteejemplo123'; 
        $hashedStudentPassword = Hash::make($studentPassword);

        if (!Hash::check($studentPassword, $hashedStudentPassword)) {
            throw new \RuntimeException("Error generando el hash para la contraseña del estudiante de ejemplo.");
        }

        DB::table('users')->updateOrInsert(
            ['email' => 'estudiante.ejemplo@academia.edu'], 
            [
                'name' => 'Estudiante Ejemplo User',    
                'password' => $hashedStudentPassword,
                'role' => 'estudiante',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
        $this->command->info('Usuario Estudiante Ejemplo creado/actualizado: estudiante.ejemplo@academia.edu | Pass: estudianteejemplo123');
    }
}
