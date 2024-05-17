<?php

namespace App\Listeners;

use App\Events\ProfileUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;

class UpdateNotificationProfile implements ShouldQueue
{
    public function handle(ProfileUpdated $event)
    {
        $updatedUser = $event->user;

        // Get all users
        $users = User::all();

        foreach ($users as $user) {
            // Fetch all notifications related to this user
            $notifications = $user->notifications;

            foreach ($notifications as $notification) {
                $data = $notification->data;

                // Check if the necessary keys are present in the notification data
                if (isset($data['commenter_name']) && isset($data['commenter_profile_image']) && isset($data['commenter_id'])) {
                    // Check if the commenter ID matches the updated user's ID
                    if ($updatedUser->id === $data['commenter_id']) {
                        // Update profile image and name in notification data
                        $data['commenter_name'] = $updatedUser->name;
                        $data['commenter_profile_image'] = $updatedUser->profile_image; // Assuming 'profile_image' is the field name

                        // Save updated data back to notification
                        $notification->data = $data;
                        $notification->save();
                    }
                }
            }
        }
    }
}


