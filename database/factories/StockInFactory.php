<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StockIn>
 */
class StockInFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => \App\Models\Product::factory(),
            'supplier_id' => \App\Models\Supplier::factory(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'date' => $this->faker->dateTimeBetween(now()->startOfYear(), now()->endOfYear()),
        ];
    }
}
