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

            // Check if the notification corresponds to a comment made by the updated user
            if ($notification->type === 'App\Notifications\NewCommentNotification' && $data['commenter_id'] === $updatedUser->id) {
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
