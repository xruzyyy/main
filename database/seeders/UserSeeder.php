<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Auth;
use App\Events\NewUserRegistered; // Import the event class

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) { // Generating 10 users as an example, you can adjust the count as needed
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;
            $email = strtolower($firstName . '.' . $lastName . '@gmail.com');


            $userData = [
                'name' => $firstName . ' ' . $lastName,
                'email' => $email,
                'status' => 1,
                'account_expiration_date' => now()->addYear(-1)->toDateTimeString(),
                'image' => $faker->imageUrl(800, 800), // Generate a fake image URL with specific dimensions
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role_as' => 'business',
                'type' => 2,
                'created_at' => '2024-03-26 12:10:00', // Set a specific created_at date and time
                'updated_at' => now(),
            ];


            try {
                // Create user
                $user = \App\Models\User::create($userData);
                $this->command->info('User ' . ($i + 1) . ' created successfully.');

                // Trigger the NewUserRegistered event
                event(new NewUserRegistered($user, $user->type));
            } catch (\Throwable $e) {
                $this->command->error('Error creating user ' . ($i + 1) . ': ' . $e->getMessage());
            }
        }
    }
}
