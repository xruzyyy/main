<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BusinessListingNotification extends Notification
{
    use Queueable;

    protected $businessListing;

    /**
     * Create a new notification instance.
     *
     * @param $businessListing
     * @return void
     */
    public function __construct($businessListing)
    {
        // Check if $businessListing is an array
        if (is_array($businessListing)) {
            // If it's an array, convert it to an object
            $this->businessListing = (object) $businessListing;
        } else {
            // If it's already an object, use it directly
            $this->businessListing = $businessListing;
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database']; // Store notification in the database
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        // Check if the authenticated user type is admin
        if ($notifiable->type === 'admin') {
            return [
                'message' => 'A new business listing has been added.',
                'business_name' => $this->businessListing->businessName,
                'user_id' => $this->businessListing->user_id,
                // You can include additional details about the business listing here
            ];
        } else {
            // Return an empty array if the user is not an admin
            return [];
        }
    }
}
