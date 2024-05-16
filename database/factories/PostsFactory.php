<?php

namespace Database\Factories;

use App\Models\Posts;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class PostsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */

    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Posts::class;

    public function definition()
    {
        return [
            'businessName' => $this->faker->unique()->company,
            'description' => $this->faker->sentence(),
            'images' => json_encode([$this->faker->imageUrl(480, 480, 'business')]), // Adjust this line if necessary
            'type' => 'Accounting', // Example type, adjust as necessary
            'is_active' => 0,
            'contactNumber' => $this->faker->unique()->randomNumber(9, true),
            'user_id' => User::factory(), // Use User factory to generate a user if necessary
        ];
    }

}
