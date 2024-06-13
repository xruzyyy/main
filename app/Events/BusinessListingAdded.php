<?php

namespace App\Events;

use App\Models\Posts;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BusinessListingAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $category;
    public $businessName;
    public $user_id; // Change from description to user_id

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\Category  $category
     * @param  string  $businessName
     * @param  int  $user_id
     * @return void
     */
    public function __construct(Posts $category, $businessName, $user_id) // Adjust the constructor parameters
    {
        $this->category = $category;
        $this->businessName = $businessName;
        $this->user_id = $user_id; // Update the property assignment
    }
}
