<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'order_number' => fake()->unique()->randomNumber("6"),
            'user_id' => User::all()->random()->id,
            'status' => fake()->randomElement(['Pending','Processing','Completed']),
            'payment_status' => fake()->randomElement(['Paid','Unpaid']),
            'grand_total' => fake()->randomNumber("4"),
        ];
    }
}
