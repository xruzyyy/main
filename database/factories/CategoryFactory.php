<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'businessName' => $this->faker->company, // Generate a random business name
            'description' => $this->faker->sentence(), // Generate a random description
            'image' => 'https://via.placeholder.com/800x800', // Use a placeholder image
            'is_active' => 1, // Set active status
        ];
    }
}
