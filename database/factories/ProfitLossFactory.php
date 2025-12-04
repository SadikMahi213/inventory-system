<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProfitLoss>
 */
class ProfitLossFactory extends Factory
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
            'revenue' => fake()->randomFloat(2, 100, 50000),
            'cogs' => fake()->randomFloat(2, 50, 30000),
            'staff_cost' => fake()->randomFloat(2, 10, 5000),
            'shop_cost' => fake()->randomFloat(2, 20, 8000),
            'transport_cost' => fake()->randomFloat(2, 5, 2000),
            'other_expense' => fake()->randomFloat(2, 0, 3000),
            'total_expenses' => fake()->randomFloat(2, 35, 18000),
            'net_profit' => fake()->randomFloat(2, 65, 32000),
            'report_date' => fake()->date(),
        ];
    }
}
