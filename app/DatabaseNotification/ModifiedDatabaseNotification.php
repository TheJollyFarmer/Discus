<?php

namespace App\DatabaseNotification;

use Illuminate\Notifications\DatabaseNotification;

/**
 * Database Notification: 'ModifiedDatabaseNotification'
 *
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $notifiable
 * @mixin \Eloquent
 */
class ModifiedDatabaseNotification extends DatabaseNotification
{
    /**
     * Mark the notification as unread.
     *
     * @return void
     */
    public function markAsUnread()
    {
        if (!is_null($this->read_at)) {
            $this->forceFill(['read_at' => null])->save();
        }
    }
}
