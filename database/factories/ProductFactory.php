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
            'code' => 'PRD-' . mt_rand(1000, 9999),
            'name' => $this->faker->word,
            'categories_id' => \App\Models\Category::factory(),
            'unit_id' => \App\Models\Unit::factory(),
            'stock' => $this->faker->numberBetween(1, 1000),
            'min_stock' => $this->faker->numberBetween(1, 10),
        ];
    }
}
