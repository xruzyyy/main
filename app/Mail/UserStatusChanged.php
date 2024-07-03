<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $statusMessage;

    /**
     * Create a new message instance.
     *
     * @param  User  $user
     * @param  string  $statusMessage
     * @return void
     */
    public function __construct(User $user, $statusMessage)
    {
        $this->user = $user;
        $this->statusMessage = $statusMessage;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Account Status Changed')
                    ->view('emails.user_status_changed');
    }
}
