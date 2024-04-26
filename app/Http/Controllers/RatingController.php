<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Posts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;


class RatingController extends Controller
{
    /**
     * Store or update the rating for a post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $postId
     * @return \Illuminate\Http\Response
     */
    public function storeRating(Request $request, $postId)
{
    // Validate the incoming request
    $request->validate([
        'rating' => 'required|numeric|between:1,5',
    ]);

    // Find the rating for the current user and post
    $rating = Rating::where('post_id', $postId)
                    ->where('user_id', auth()->id())
                    ->first();

    // If the rating exists, update it; otherwise, create a new one
    if ($rating) {
        $rating->rating = $request->input('rating');
        $rating->save();
    } else {
        // Create a new rating instance
        $rating = new Rating();
        $rating->post_id = $postId;
        $rating->rating = $request->input('rating');
        $rating->user_id = auth()->id();
        $rating->save();
    }

    // Redirect back to the post page
    return redirect()->back()->with('success', 'Rating submitted successfully.');
}
}
