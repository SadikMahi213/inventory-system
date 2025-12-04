<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PurchaseRecord>
 */
class PurchaseRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => fake()->date(),
            'product_name' => fake()->words(3, true),
            'model' => fake()->word(),
            'size' => fake()->randomElement(['Small', 'Medium', 'Large', 'XL', 'XXL']),
            'color' => fake()->colorName(),
            'quality' => fake()->randomElement(['Standard', 'Premium', 'Deluxe']),
            'quantity' => fake()->numberBetween(10, 1000),
            'unit' => fake()->randomElement(['pcs', 'kg', 'liters', 'boxes']),
            'unit_price' => fake()->randomFloat(2, 10, 1000),
            'total_price' => fake()->randomFloat(2, 100, 10000),
            'payment_status' => fake()->randomElement(['pending', 'paid', 'partial']),
        ];
    }
}
