<?php

namespace App\Listeners;

use App\Events\BusinessListingAdded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\BusinessListingNotification;

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

        // Send notification
        $category->user->notify(new BusinessListingNotification([
            'businessName' => $businessName,
            'user_id' => $user_id,
        ]));
    }
}
