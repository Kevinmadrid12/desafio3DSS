<?php

namespace Database\Factories;

use App\Models\Asistencia;
use App\Models\Estudiante;
use App\Models\Tutor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asistencia>
 */
class AsistenciaFactory extends Factory
{
      /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Asistencia::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fecha' => fake()->dateTimeThisYear()->format('Y-m-d'),
            'codigo_estudiante' => Estudiante::inRandomOrder()->first()?->codigo ?? Estudiante::factory(),
            'codigo_tutor' => Tutor::inRandomOrder()->first()?->codigo ?? Tutor::factory(),
            'tipo' => fake()->randomElement(['A', 'I', 'J']),
        ];
    }
}
