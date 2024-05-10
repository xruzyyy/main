<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Posts;
use Faker\Factory as Faker;
use App\Models\User;

class PostsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $faker = Faker::create();

        // Get all user ids
        $userIds = User::pluck('id')->toArray();

        // Generate 10 posts with unique business names and different images
        // Define the array containing the list of posts
$posts = [
    "Accounting",
    "Agriculture",
    "Construction",
    "Education",
    "Finance",
    "Retail",
    "Fashion Photography Studios",
    "Healthcare",
    "Coffee Shops",
    "Information Technology",
    "Shopping Malls",
    "Trading Goods",
    "Consulting",
    "Barbershop",
    "Fashion Consultancy",
    "Beauty Salon",
    "Logistics",
    "Sports",
    "Pets",
    "Entertainment",
    "Pattern Making Services",
    "Maintenance",
    "Pharmaceuticals",
    "Automotive",
    "Environmental",
    "Food & Beverage",
    "Garment Manufacturing",
    "Fashion Events Management",
    "Retail Clothing Stores",
    "Fashion Design Studios",
    "Shoe Manufacturing",
    "Tailoring and Alterations",
    "Textile Printing and Embroidery",
    "Fashion Accessories",
    "Boutiques",
    "Apparel Recycling and Upcycling",
    "Apparel Exporters",
];
        for ($i = 0; $i < 1000; $i++) {
            Posts::factory()->create([
                'businessName' => $faker->unique()->company,
                'description' => $faker->sentence(),
                'image' => $this->getRandomImage(),
                'type' => $posts[array_rand($posts)], // Randomly select a type from the $posts array
                'is_active' => 0,
                'contactNumber' => $faker->unique()->randomNumber(9, true), // Generate a random 9-digit contact number
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
