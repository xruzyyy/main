<?php

namespace App\Listeners;

use App\Events\BusinessListingAdded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\BusinessListingNotification;
use App\Models\User; // Don't forget to import the User model

class ProcessBusinessListing
{
    /**
     * Handle the event.
     *
     * @param  BusinessListingAdded  $event
     * @return void
     */
    public function handle(BusinessListingAdded $event)
    {
        // Retrieve information from the event
        $category = $event->category;
        $businessName = $event->businessName;
        $user_id = $event->user_id;

        // Get all users or the specific group of users you want to notify
        $users = User::all(); // Change this to fetch specific users if needed

        // Send notification to each user
        foreach ($users as $user) {
            $user->notify(new BusinessListingNotification([
                'businessName' => $businessName,
                'user_id' => $user_id, // You might need to adjust this depending on your logic
            ]));
        }
    }
}
