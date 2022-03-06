<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeaderboardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'user_id' => $this->faker->numberBetween(1, User::count()),
            'points' => $this->faker->randomNumber(1,60),
            'created_at' => $this->faker->dateTimeBetween('-60 days', 'now')
        ];
    }
}
