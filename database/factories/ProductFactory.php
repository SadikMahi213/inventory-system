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
            'product_code' => 'PRD-' . strtoupper(fake()->lexify('???')) . fake()->numerify('###'),
            'name' => fake()->words(3, true),
            'model' => fake()->word(),
            'size' => fake()->randomElement(['Small', 'Medium', 'Large', 'XL', 'XXL']),
            'color' => fake()->colorName(),
            'quality' => fake()->randomElement(['Standard', 'Premium', 'Deluxe']),
            'unit' => fake()->randomElement(['pcs', 'kg', 'liters', 'boxes']),
            'unit_price' => fake()->randomFloat(2, 10, 1000),
            'selling_price' => fake()->randomFloat(2, 15, 1500),
            'description' => fake()->sentence(),
            'is_featured' => fake()->boolean(20),
        ];
    }
}
