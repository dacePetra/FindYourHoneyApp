<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PictureFactory extends Factory
{

    public function definition()
    {
        $randomFemaleNumber = rand(111, 140);
        $randomMaleNumber = rand(211, 240);

        // FEMALE

        return [
            'user_id' => rand(61, 120),
            'original_picture' => "pictures/{$randomFemaleNumber}.jpg",
            'picture' => "pictures/{$randomFemaleNumber}.jpg"
        ];

        // MALE
        /*
        return [
            'user_id' => rand(1, 60),
            'original_picture' => "pictures/{$randomMaleNumber}.jpg",
            'picture' => "pictures/{$randomMaleNumber}.jpg"
        ];
        */
    }

}
