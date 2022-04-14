<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserInterests>
 */
class UserInterestsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $users = User::pluck('id')->toArray();
        return [
            'user_id' => User::all()->containsOneItem(),  //  User::factory(),
            'interested_in' => $this->faker->randomElement(['female', 'male', 'both']),
            'age_from' => $this->faker->numberBetween($int1 = 18, $int2 = 50),
            'age_to' => $this->faker->numberBetween($int1 = 51, $int2 = 100)
        ];
    }
}
