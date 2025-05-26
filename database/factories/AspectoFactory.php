<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Aspecto;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Aspecto>
 */
class AspectoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Aspecto::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'descripcion' => fake()->sentence(3),
            'tipo' => fake()->randomElement(['P', 'L', 'G', 'MG']),
        ];
    }
}
