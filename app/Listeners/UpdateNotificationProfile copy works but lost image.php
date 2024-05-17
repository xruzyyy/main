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

        // Fetch all notifications related to this user
        $notifications = $updatedUser->notifications;

        foreach ($notifications as $notification) {
            $data = $notification->data;

            // Check if the necessary keys are present in the notification data
            if (isset($data['commenter_id']) && $data['commenter_id'] === $updatedUser->id) {
                // Update profile image and name in notification data
                if (isset($data['commenter_name'])) {
                    $data['commenter_name'] = $updatedUser->name;
                }
                if (isset($data['commenter_profile_image'])) {
                    $data['commenter_profile_image'] = $updatedUser->profile_image;
                }

                // Save updated data back to notification
                $notification->data = $data;
                $notification->save();
            }
        }
    }
}
