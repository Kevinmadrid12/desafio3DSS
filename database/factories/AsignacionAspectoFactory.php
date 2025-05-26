<?php

namespace Database\Factories;

use App\Models\AsignacionAspecto;
use App\Models\Aspecto;
use App\Models\Estudiante;
use App\Models\Tutor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AsignacionAspecto>
 */
class AsignacionAspectoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AsignacionAspecto::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
             'aspecto_id' => Aspecto::inRandomOrder()->first()?->id ?? Aspecto::factory(),
            'fecha' => fake()->dateTimeThisYear()->format('Y-m-d'),
            'codigo_estudiante' => Estudiante::inRandomOrder()->first()?->codigo ?? Estudiante::factory(),
            'codigo_tutor' => Tutor::inRandomOrder()->first()?->codigo ?? Tutor::factory(),
        ];
    }
}
