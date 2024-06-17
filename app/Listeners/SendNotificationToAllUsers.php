<?php

namespace App\Listeners;

use App\Events\NewUserRegistered;
use App\Models\User;
use App\Notifications\NewUserNotification;

class SendNotificationToAllUsers
{
    /**
     * Handle the event.
     *
     * @param  NewUserRegistered  $event
     * @return void
     */
    public function handle(NewUserRegistered $event)
    {
        $newUser = $event->user;

        // Get the admin user
        $admin = User::where('type', 1)->first();

        // Send notification to the admin only
        if ($admin) {
            $admin->notify(new NewUserNotification($newUser));
        }
    }
}
