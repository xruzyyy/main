<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * Get the user who sent the message.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the conversation the message belongs to.
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
    
}
