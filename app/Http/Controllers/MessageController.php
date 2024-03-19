<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Conversation;
use App\Models\Message; 
use App\Events\MessageSent;

class MessageController extends Controller
{
    public function index(Conversation $conversation)
    {
        $messages = $conversation->messages()->latest()->get();
        return response()->json($messages);
    }


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

        // Trigger MessageSent event
        event(new MessageSent($message));

        return response()->json($message, 201);
    }

}
