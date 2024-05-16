<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewUserNotification extends Notification
{
    use Queueable;

    protected $newUser;

    /**
     * Create a new notification instance.
     *
     * @param $newUser
     * @return void
     */
    public function __construct($newUser)
    {
        $this->newUser = $newUser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database']; // Send notification via email and store in the database
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // Define the email message
        return (new MailMessage)
                    ->line('A new user has been registered.')
                    ->line('Name: ' . $this->newUser->name)
                    ->line('Type: ' . $this->newUser->type);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'A new user has been registered.',
            'new_user_name' => $this->newUser->name,
            'new_user_type' => $this->newUser->type, // Include the user type in the notification
        ];
    }
}
