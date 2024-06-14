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

        // Get all admin users
        $adminUsers = User::where('type', 1)->get(); // Assuming '1' represents admin users

        // Send notification to each admin user
        foreach ($adminUsers as $adminUser) {
            $adminUser->notify(new BusinessListingNotification([
                'businessName' => $businessName,
                'user_id' => $user_id, // You might need to adjust this depending on your logic
            ]));
        }
    }
}
