<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Faker\Factory as Faker;
use App\Models\User; 

class CategorySeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $faker = Faker::create();

        // Get all user ids
        $userIds = User::pluck('id')->toArray();

        // Generate 10 categories with unique business names and different images
        for ($i = 0; $i < 10; $i++) {
            Category::factory()->create([
                'businessName' => $faker->unique()->company,
                'description' => $faker->sentence(),
                'image' => $this->getRandomImage(),
                'is_active' => 0,
                'user_id' => $faker->randomElement($userIds), // Assign a random user_id
            ]);
        }
    }

    /**
     * Get a random image URL from a free image hosting service.
     *
     * @return string
     */
    private function getRandomImage()
    {
        $imageHosts = [
            'https://source.unsplash.com/collection/928423/480x480', // Unsplash
            // Add more free image hosting URLs here if needed
        ];

        // Choose a random image URL from the array of hosts
        $randomHost = array_rand($imageHosts);
        return $imageHosts[$randomHost];
    }
}
