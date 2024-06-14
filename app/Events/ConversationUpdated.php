<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ConversationUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $conversation;

    public function __construct($conversation)
    {
        $this->conversation = $conversation;
    }

    public function broadcastOn()
    {
        return ['conversation-updates'];
    }
}
