<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class PurchaseTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'total_spent'       => $this->faker->randomFloat(true, 1, 1000),
            'total_saving'      => $this->faker->randomFloat(true, 1, 100),
            'transaction_at'    => $this->faker->dateTimeBetween(Carbon::now()->subDays(45), Carbon::now()),
        ];
    }
}
