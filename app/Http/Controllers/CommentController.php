<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Rating;

class CommentController extends Controller
{
    /**
     * Store a newly created comment for the specified business post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   // ManagePostController.php



   public function storeComment(Request $request, $id)
   {
       // Validate the request data
       $request->validate([
           'content' => 'required|string|max:255',
       ]);

       // Find the category/post by its ID
       $post = Posts::findOrFail($id);

       // Create a new Comment instance
       $comment = new Comment();
       $comment->content = $request->content;
       $comment->user_id = auth()->user()->id; // Assuming the user is authenticated
       // Associate the comment with the category/post
       $post->comments()->save($comment);

       // Redirect back with a success message
       return redirect()->back()->with('success', 'Comment added successfully!');
   }


   public static function generateStarsForUser($postId, $userId)
    {
        // Retrieve the user's rating for the specified post
        $rating = Rating::where('post_id', $postId)
                        ->where('user_id', $userId)
                        ->first();

        // If the user has rated the post, generate star icons based on their rating
        if ($rating) {
            $stars = '';
            for ($i = 0; $i < $rating->rating; $i++) {
                $stars .= '<i class="fas fa-star" style="color: gold;"></i>';
            }
            return $stars;
        }

        // If the user hasn't rated the post, return an empty string
        return '';
    }
}
