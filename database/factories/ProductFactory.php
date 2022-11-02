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
            'name' => fake()->randomElement(["iPhone 9","iPhone X","Samsung Universe 9","OPPOF19","Huawei P30",
            "Samsung Galaxy Book","Infinix INBOOK","HP Pavilion 15-DK1056WM"]) . fake()->randomNumber(1),
            'sku' => fake()->unique()->randomNumber("6"),
            'description' => fake()->text(),
            'price' => fake()->randomNumber("4"),
            'status' => fake()->randomElement([1,0]),
            'featured' => fake()->randomElement([1,0]),
        ];
    }
}
