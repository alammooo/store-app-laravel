<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'buyPrice' => fake()->numberBetween(100000, 50000000),
            'sellPrice' => fake()->numberBetween(100000, 50000000),
            'stock' => fake()->numberBetween(2, 50),
            'image' => fake()->imageUrl(),
            'categoryId' => fake()->numberBetween(1, 2),
        ];
    }
}
