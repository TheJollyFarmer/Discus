<?php

namespace App\Listeners;

use App\Events\UserHasNewFriend;
use App\Notifications\UserMadeAFriend;
use App\User;

class NotifyNewFriend
{
    /**
     * Handle the event.
     *
     * @param UserHasNewFriend $event
     * @return void
     */
    public function handle(UserHasNewFriend $event)
    {
        $user = User::where('id', $event->friendship->second_user)->first();

        User::where('id', $event->friendship->first_user)
            ->first()
            ->notify(new UserMadeAFriend($user, $event->friendship));
    }
}
