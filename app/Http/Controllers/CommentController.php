<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Rating;
use App\Notifications\NewCommentNotification;
use App\Models\User;

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

   // CommentController.php

   public function storeComment(Request $request, $id)
{
    $request->validate([
        'content' => 'required|string|max:255',
    ]);

    $post = Posts::findOrFail($id);

    // Find the latest comment by the authenticated user
    $latestComment = Comment::where('posts_id', $post->id)
                            ->where('user_id', auth()->user()->id)
                            ->latest()
                            ->first();

    // If there's a latest comment, check if it's the same as the new one
    if ($latestComment && $latestComment->content === $request->content) {
        return redirect()->back()->with('error', 'You have already left the same comment.');
    }

    // If the latest comment exists and is different, update it
    if ($latestComment) {
        $latestComment->content = $request->content;
        $latestComment->save();
        return redirect()->back()->with('success', 'Comment updated successfully!');
    }

    // If there's no latest comment or it's different, create a new one
    $comment = new Comment();
    $comment->content = $request->content;
    $comment->user_id = auth()->user()->id;
    $post->comments()->save($comment);
    $post->increment('comments');

    // Notify post author about the new comment
    $post->user->notify(new NewCommentNotification($comment, auth()->user()->name, auth()->user()->profile_image));

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
