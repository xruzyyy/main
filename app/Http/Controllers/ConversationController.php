<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Events\ConversationUpdated;

class ConversationController extends Controller
{
    /**
     * Display a listing of the conversations.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conversations = Conversation::all();
        return response()->json($conversations);
        return view('conversations.index', compact('conversations'));
    }


    /**
     * Display the specified conversation.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function show(Conversation $conversation)
    {
        return response()->json($conversation);
    }

    /**
     * Store a newly created conversation in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $conversation = Conversation::create($request->all());
        
        // Trigger ConversationUpdated event
        event(new ConversationUpdated($conversation));
        
        return response()->json($conversation, 201);
    }


    /**
     * Update the specified conversation in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conversation $conversation)
    {
        $conversation->update($request->all());
        return response()->json($conversation, 200);
    }

    /**
     * Remove the specified conversation from storage.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conversation $conversation)
    {
        $conversation->delete();
        return response()->json(null, 204);
    }
}
