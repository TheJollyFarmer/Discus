<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserHasNewFriend
{
    use Dispatchable, SerializesModels;

    /**
     * @var Friendship $friendship
     */
    public $friendship;

    /**
     * Create a new event instance.
     *
     * @param $friendship
     */
    public function __construct($friendship)
    {
        $this->friendship = $friendship;
    }
}
