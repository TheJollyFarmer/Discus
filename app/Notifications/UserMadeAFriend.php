<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class UserMadeAFriend extends Notification
{
    use Queueable;

    /**
     * @var
     */
    protected $user;

    /**
     * @var
     */
    protected $friendship;

    /**
     * Create a new notification instance.
     *
     * @param $user
     * @param $friendship
     */
    public function __construct($user, $friendship)
    {
        $this->user = $user;
        $this->friendship = $friendship;
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
            'user' => $this->user->name,
            'avatar' => $this->user->avatar_path,
            'link' => '/profiles/' . $this->user->name
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'created_at' => $this->friendship->created_at->format('Y-m-d H:i:s'),
            'data' => [
                'user' => $this->user->name,
                'avatar' => $this->user->avatar_path,
                'link' => '/profiles/' . $this->user->name
            ],
            'notifiable_id' => $notifiable->id,
            'read_at' => null,
            'type' => $notifiable->type,
            'updated_at' => $this->friendship->updated_at->format('Y-m-d H:i:s'),
        ]);
    }
}
