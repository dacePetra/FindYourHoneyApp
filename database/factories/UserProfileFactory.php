<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserProfile>
 */
class UserProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $randomFemaleNumber = rand(111, 140);
        $randomMaleNumber = rand(211, 240);
        $adultFromDate = now()->subYears(18)->format('Y-m-d');
        // FEMALE

        return [
            'user_id' => User::factory(),
            'gender' => 'female',
            'birthday' => $this->faker->date($format = 'Y-m-d', $max = '2004-04-04'),
            'original_picture' => "pictures/{$randomFemaleNumber}.jpg",
            'picture' => "pictures/{$randomFemaleNumber}.jpg",
            'location' => $this->faker->city(),
            'about' => $this->faker->text(50),
            'created_at' => now(),
            'updated_at' => now()
        ];


        // MALE
/*
        return [
            'user_id' => User::factory(),
            'gender' => 'male',
            'birthday' => $this->faker->date($format = 'Y-m-d', $max = $adultFromDate),
            'original_picture' => 'pictures/large.jpg',
            'picture' => "pictures/{$randomMaleNumber}.jpg",
            'location' => $this->faker->city(),
            'about' => $this->faker->text(50),
            'created_at' => now(),
            'updated_at' => now()
        ];
*/

        // BEFORE
        /*
        return [
            'user_id' => User::factory(),
            'gender' => $this->faker->randomElement(['female', 'male']),
            'birthday' => $this->faker->date($format = 'Y-m-d', $max = $adultFromDate),
            'original_picture' => 'pictures/large.jpg',
            'picture' => 'pictures/small.jpg',
            'location' => $this->faker->city(),
            'about' => $this->faker->text(50),
            'created_at' => now(),
            'updated_at' => now()
        ];
        */
    }
}
