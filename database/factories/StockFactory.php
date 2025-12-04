<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => null,
            'purchase_quantity' => fake()->numberBetween(10, 1000),
            'sales_quantity' => fake()->numberBetween(0, 500),
            'current_stock' => fake()->numberBetween(0, 500),
            'average_cost' => fake()->randomFloat(2, 10, 1000),
        ];
    }
}
