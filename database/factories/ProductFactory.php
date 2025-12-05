<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_name' => $this->faker->words(3, true),
            'size' => $this->faker->randomElement(['Small', 'Medium', 'Large', 'X-Large']),
            'brand' => $this->faker->company(),
            'grade' => $this->faker->randomElement(['A', 'A+', 'A++', 'B', 'B+', 'C']),
            'material' => $this->faker->randomElement(['Plastic', 'Metal', 'Wood', 'Glass', 'Fabric']),
            'color' => $this->faker->colorName(),
            'model_no' => $this->faker->bothify('??-####'),
            'product_code' => 'PRD-' . strtoupper($this->faker->lexify('???')) . '-' . $this->faker->numerify('###'),
            'unit_qty' => $this->faker->randomFloat(2, 1, 100),
            'unit' => $this->faker->randomElement(['piece', 'kg', 'meter', 'liter']),
            'unit_rate' => $this->faker->randomFloat(2, 10, 1000),
            'total_buy' => $this->faker->randomFloat(2, 100, 10000),
            'category_id' => Category::factory(),
            'quantity' => $this->faker->randomFloat(2, 0, 1000),
            'approximate_rate' => $this->faker->randomFloat(2, 10, 1000),
            'authentication_rate' => $this->faker->randomFloat(2, 10, 1000),
            'sell_rate' => $this->faker->randomFloat(2, 10, 1000),
        ];
    }
}