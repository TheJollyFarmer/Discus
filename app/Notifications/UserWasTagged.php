<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class UserWasTagged extends Notification
{
    use Queueable;

    /**
     * @var \App\Reply
     */
    protected $reply;

    /**
     * Create a new notification instance.
     *
     * @param \App\Reply $reply
     */
    public function __construct($reply)
    {
        $this->reply = $reply;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user' => $this->reply->owner->name,
            'avatar' => $this->reply->owner->avatar_path,
            'thread_title' => $this->reply->thread->title,
            'reply_id' => $this->reply->id,
            'thread_id' => $this->reply->thread->id,
            'link' => $this->reply->path()
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'created_at' => $this->reply->created_at->format('Y-m-d H:i:s'),
            'data' => [
                'user' => $this->reply->owner->name,
                'avatar' => $this->reply->owner->avatar_path,
                'thread_title' => $this->reply->thread->title,
                'reply_id' => $this->reply->id,
                'thread_id' => $this->reply->thread->id,
                'link' => $this->reply->path()
            ],
            'notifiable_id' => $notifiable->id,
            'read_at' => null,
            'type' => $notifiable->type,
            'updated_at' => $this->reply->updated_at->format('Y-m-d H:i:s'),
        ]);
    }
}
