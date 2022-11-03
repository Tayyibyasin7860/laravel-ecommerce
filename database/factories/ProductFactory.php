<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
    public function definition()
    {
        return [
            'name' => ucwords(fake()->words(2, "true")),
            'sku' => fake()->unique()->randomNumber("6"),
            'description' => fake()->text(),
            'price' => fake()->randomNumber("4"),
            'status' => fake()->randomElement([1,0]),
            'featured' => fake()->randomElement([1,0]),
        ];
    }
}
