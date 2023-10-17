<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\Request;

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
    public function definition(): array
    {
        return [
            'bill_id'=>fake()->numberBetween(1,50),
            'payor_id'=>fake()->numberBetween(1,2),
            'payment_method'=>fake()->numberBetween(1,4),
            'status'=>fake()->numberBetween(1,3)
        ];
    }
}
