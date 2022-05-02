<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class ThreadWasUpdated extends Notification
{
    use Queueable;

    /**
     * @var
     */
    protected $thread;

    /**
     * @var
     */
    protected $reply;

    /**
     * Create a new notification instance.
     *
     * @param $thread
     * @param $reply
     */
    public function __construct($thread, $reply)
    {
        $this->thread = $thread;
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
            'base_link' => $this->thread->path(),
            'user' => $this->reply->owner->name,
            'avatar' => $this->reply->owner->avatar_path,
            'thread_title' => $this->thread->title,
            'reply_body' => $this->reply->body,
            'reply_id' => $this->reply->id,
            'thread_id' => $this->thread->id
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'created_at' => $this->reply->created_at->format('Y-m-d H:i:s'),
            'data' => [
                'avatar' => $this->reply->owner->avatar_path,
                'channel' => $this->thread->channel->slug,
                'user' => $this->reply->owner->name,
                'thread_title' => $this->thread->title,
                'reply_body' => $this->reply->body,
                'reply_id' => $this->reply->id,
                'thread_id' => $this->thread->id,
                'slug' => $this->thread->slug
            ],
            'notifiable_id' => $notifiable->id,
            'read_at' => null,
            'type' => $notifiable->type,
            'updated_at' => $this->reply->updated_at->format('Y-m-d H:i:s'),
        ]);
    }
}
