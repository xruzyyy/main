<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Posts; // Update model namespace
use App\Models\Rating;
use App\Models\Comment;

class PostsRatingsAndReviewsSeeder extends Seeder
{
    /**
     * Seed the application's database with ratings, comments, and comments for posts.
     */
    public function run()
    {
        // Get all posts
        $posts = Posts::all(); // Update model reference to Post

        // Loop through each post
        foreach ($posts as $post) {
            // Generate a random number of new ratings
            $newRatingsCount = rand(250, 500);

            // Update the ratings count for the post
            $post->ratings_count += $newRatingsCount;

            // Save the changes to the post
            $post->save();

            // Create new ratings for the post
            for ($i = 0; $i < $newRatingsCount; $i++) {
                Rating::create([ // Update model reference to Rating
                    'post_id' => $post->id,
                    'user_id' => $post->user_id, // Assuming user_id for the post owner
                    'rating' => rand(3, 5),
                ]);
            }

            // // Generate a random number of new comments
            // $newcommentsCount = rand(250, 500);

            // // Update the comments count for the post
            // $post->comments += $newcommentsCount;

            // // Save the changes to the post
            // $post->save();

            // // Create new comments for the post
            // for ($i = 0; $i < $newcommentsCount; $i++) {
            //     $post->comments()->create([
            //         'user_id' => $post->user_id, // Assuming user_id for the post owner
            //         'content' => $this->generateRandomComment(),
            //     ]);
            // }
        }
    }

    /**
     * Generate a random comment.
     */
    // private function generateRandomComment()
    // {
    //     // Define an array of random comments
    //     $randomComments = [
    //         'Great post!',
    //         'Amazing content!',
    //         'Thanks for sharing!',
    //         'Very informative!',
    //         'How truly legit is this!',
    //     ];

    //     // Select a random comment from the array
    //     return $randomComments[array_rand($randomComments)];
    // }
}
