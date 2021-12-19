<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name'    => $this->faker->firstName(),
            'last_name'     => $this->faker->lastName(),
            'gender'        => $this->faker->randomElement(['male', 'female']),
            'date_of_birth' =>  $this->faker->dateTimeBetween('1987-01-01', '2009-12-31'),
            'email'         => $this->faker->unique()->safeEmail(),
            'password'      => bcrypt('aichat123')
        ];
    }
}
