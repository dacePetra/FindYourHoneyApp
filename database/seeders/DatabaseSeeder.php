<?php

namespace Database\Seeders;

use App\Models\Picture;
use App\Models\User;
use App\Models\UserInterests;
use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//      User::factory(10)->create();
//      UserProfile::factory(10)->create();
//        Picture::factory(200)->create();

        UserProfile::factory(60)->create()->each(function ($profile) {
            UserInterests::factory(1)->create([
                'user_id' => $profile->user_id
            ]);
        });
    }
}

