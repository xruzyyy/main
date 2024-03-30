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

        // Get all existing users except the newly registered user
        $users = User::where('id', '!=', $newUser->id)->get();

        // Send notification to each user
        foreach ($users as $user) {
            $user->notify(new NewUserNotification($newUser));
        }
    }
}
