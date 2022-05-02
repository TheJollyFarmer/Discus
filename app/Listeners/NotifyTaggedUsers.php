<?php

namespace App\Listeners;

use App\Events\ThreadReceivedNewReply;
use App\Notifications\UserWasTagged;
use App\User;

class NotifyTaggedUsers
{
    /**
     * Handle the event.
     *
     * @param  ThreadReceivedNewReply $event
     * @return void
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        User::whereIn('name', $event->reply->taggedUsers())
            ->get()
            ->each
            ->notify(new UserWasTagged($event->reply));
    }
}
