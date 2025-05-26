<?php

namespace Database\Factories;

use App\Models\Estudiante;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estudiante>
 */
class EstudianteFactory extends Factory
{
     /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Estudiante::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'codigo' => 'EST-' . Str::upper(Str::random(5)),
            'nombres' => fake()->firstName(),
            'apellidos' => fake()->lastName(),
            'dui' => fake()->unique()->numerify('########-#'),
            'email' => fake()->unique()->safeEmail(),
            'telefono' => fake()->numerify('####-####'),
            'fecha_nacimiento' => fake()->date(),
            'fotografia' => null, // O fake()->imageUrl(640, 480, 'people', true, 'Faker')
            'estado' => fake()->randomElement(['activo', 'inactivo']),
        ];
    }
}
