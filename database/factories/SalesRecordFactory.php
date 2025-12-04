<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SalesRecord>
 */
class SalesRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_no' => 'INV-' . strtoupper(fake()->lexify('???')) . fake()->numerify('####'),
            'customer_id' => null,
            'product_id' => null,
            'product_name' => fake()->words(3, true),
            'price' => fake()->randomFloat(2, 15, 1500),
            'quantity' => fake()->numberBetween(1, 50),
            'total_amount' => fake()->randomFloat(2, 15, 75000),
            'payment_status' => fake()->randomElement(['pending', 'paid', 'partial']),
        ];
    }
}
