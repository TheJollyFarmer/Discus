<?php

use App\Group;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
 */

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int)$user->id === (int)$id;
});

Broadcast::channel('users.{id}', function ($user, $id) {
    return (int)$user->id === (int)$id;
});

Broadcast::channel('groups.{group}', function ($user, Group $group) {
    return $group->hasUser($user->id);
});

Broadcast::channel('chat.{group}', function ($user) {
    return Auth::check();
});
