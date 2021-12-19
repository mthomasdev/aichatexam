<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text($maxNbChars = 255),
            'start_at' => Carbon::now(),
            'end_at' => Carbon::now()->addDays(30),
            'campaign_link' => $this->faker->url(),
            'is_active' => true,
        ];
    }
}
