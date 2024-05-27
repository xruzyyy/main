<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Post;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Store a newly created rating in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $postId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $postId)
    {
        // Validate the request data
        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
        ]);

        // Find the post by ID
        $post = Posts::findOrFail($postId);

        // Check if the user has already rated the post
        $existingRating = $post->ratings()->where('user_id', Auth::id())->exists();

        if ($existingRating) {
            // If the user has already rated the post, update their existing rating
            $post->ratings()->updateExistingPivot(Auth::id(), ['rating' => $request->rating]);
        } else {
            // If the user has not rated the post yet, create a new rating entry
            $post->ratings()->attach(Auth::id(), ['rating' => $request->rating]);
        }

        // Recalculate average rating for the post
        $post->average_rating = $post->ratings()->avg('rating');
        $post->ratings_count = $post->ratings()->count();
        $post->save();

        return redirect()->back()->with('success', 'Rating submitted successfully.');
    }
}
