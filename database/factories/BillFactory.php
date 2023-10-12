<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bill>
 */
class BillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'refnum'=>fake()->ean13(),
            'biller_id'=>fake()->randomDigitNotNull(),
            'bill_category'=>fake()->numberBetween(1,5),
            'billed_to'=>fake()->words(2,true),
            'description'=>fake()->sentence(),
            'amount'=>fake()->randomFloat(2,0.0,99999.99),
            'status'=>1
        ];
    }
}
