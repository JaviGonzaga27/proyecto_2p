<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->words(2, true),
            'codigo' => strtoupper($this->faker->unique()->lexify('?????')),
            'cantidad' => $this->faker->numberBetween(10, 100),
            'precio' => $this->faker->randomFloat(2, 10, 1000),
        ];
    }
}
