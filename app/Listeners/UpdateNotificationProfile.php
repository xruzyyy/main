<?php

namespace App\Listeners;

use App\Events\ProfileUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateNotificationProfile implements ShouldQueue
{
    public function handle(ProfileUpdated $event)
    {
        $user = $event->user;

        // Fetch all notifications related to this user
        $notifications = $user->notifications;

        foreach ($notifications as $notification) {
            $data = $notification->data;

            // Update profile image and name in notification data
            if (isset($data['commenter_name']) && isset($data['commenter_profile_image'])) {
                $data['commenter_name'] = $user->name;
                $data['commenter_profile_image'] = $user->profile_image; // assuming profile_image is the field name

                // Save updated data back to notification
                $notification->data = $data;
                $notification->save();
            }
        }
    }
}
