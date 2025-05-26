<?php

namespace Database\Factories;

use App\Models\Tutor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tutor>
 */
class TutorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tutor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'codigo' => 'TUT-' . Str::upper(Str::random(5)),
            'nombres' => fake()->firstName(),
            'apellidos' => fake()->lastName(),
            'dui' => fake()->unique()->numerify('########-#'),
            'email' => fake()->unique()->safeEmail(),
            'telefono' => fake()->numerify('####-####'),
            'fecha_nacimiento' => fake()->date(),
            'fecha_contratacion' => fake()->date(),
            'estado' => fake()->randomElement(['contratado', 'despedido', 'renuncia']),
        ];
    }
}
