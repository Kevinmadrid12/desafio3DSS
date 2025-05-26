<?php

namespace Database\Factories;

use App\Models\Grupo;
use App\Models\Tutor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Grupo>
 */
class GrupoFactory extends Factory
{

     /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Grupo::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
             'nombre' => 'Grupo de ' . fake()->word() . ' ' . fake()->randomElement(['I', 'II', 'Avanzado', 'Básico']),
            'codigo_tutor' => Tutor::inRandomOrder()->first()?->codigo ?? Tutor::factory(),
        ];
    }
}
