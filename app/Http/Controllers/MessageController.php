<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Conversation;
use App\Models\Message; 
use App\Events\MessageSent;
use Carbon\Carbon;

class MessageController extends Controller
{

public function store(Request $request)
{
    $user = auth()->user();
    $conversationId = $request->input('conversation_id');
    $content = $request->input('content');

    // Check if the user is part of the conversation
    $conversation = Conversation::find($conversationId);
    if (!$conversation || !$conversation->users()->where('id', $user->id)->exists()) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    // Create a new message
    $message = $conversation->messages()->create([
        'user_id' => $user->id,
        'content' => $content,
    ]);

    // Mark the message as read for the sender
    $message->update(['read_at' => Carbon::now()]);

    return response()->json($message, 201);
}

public function index(Conversation $conversation)
{
    $user = auth()->user();

    // Fetch messages for the conversation
    $messages = $conversation->messages()->latest()->get();

    // Count unread messages for the current user
    $unreadCount = $messages->where('user_id', '!=', $user->id)->whereNull('read_at')->count();

    // Respond with messages and unread count
    return response()->json(['messages' => $messages, 'unread_count' => $unreadCount]);
}


}
