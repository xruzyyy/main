<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewCommentNotification extends Notification
{
    use Queueable;

    protected $comment;
    protected $commenterName;
    protected $commenterProfileImage;

    public function __construct(Comment $comment, $commenterName, $commenterProfileImage)
    {
        $this->comment = $comment;
        $this->commenterName = $commenterName;
        $this->commenterProfileImage = $commenterProfileImage;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'comment_id' => $this->comment->id,
            'comment_content' => $this->comment->content,
            'commenter_name' => $this->commenterName,
            'commenter_profile_image' => $this->commenterProfileImage,
        ];
    }
}
