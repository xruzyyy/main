<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use SebastianBergmann\Type\VoidType;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(5)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',   
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            UserSeeder::class,
            // Other seeders...
        ]);
    }  
    
}


