<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewMessageFromAlumni extends Notification
{
    use Queueable;

    public function __construct(public Message $message) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message_id' => $this->message->id,
            'subject'    => $this->message->subject,
            'from_name'  => $this->message->sender->name,
            'type'       => 'new_message',
            'url'        => route('messages.show', $this->message->id),
        ];
    }
}
