<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;

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


}
