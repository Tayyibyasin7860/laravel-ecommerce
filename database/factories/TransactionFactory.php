<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'order_id' => Order::all()->random()->id,
            'transaction_no' => fake()->unique()->randomNumber("6"),
            'amount' => fake()->randomNumber("4"),
            'status' => fake()->randomElement(['Paid','Refund']),
        ];
    }
}
