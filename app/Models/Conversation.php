<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Message; // Add this line

class Conversation extends Model
{
    /**
     * Get the users participating in the conversation.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get the messages in the conversation.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
