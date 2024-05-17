<?php

namespace App\Listeners;

use App\Events\ProfileUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;
class UpdateNotificationProfile implements ShouldQueue
{
    public function handle(ProfileUpdated $event)
    {
        // Get all users
        $users = User::all();

        foreach ($users as $user) {
            // Fetch all notifications related to this user
            $notifications = $user->notifications;

            foreach ($notifications as $notification) {
                $data = $notification->data;

                // Update profile image and name in notification data
                if (isset($data['commenter_name']) && isset($data['commenter_profile_image'])) {
                    $data['commenter_name'] = $event->user->name;
                    $data['commenter_profile_image'] = $event->user->profile_image;

                    // Save updated data back to notification
                    $notification->data = $data;
                    $notification->save();
                }
            }
        }
    }
}
