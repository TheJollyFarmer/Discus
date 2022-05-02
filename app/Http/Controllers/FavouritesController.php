<?php

namespace App\Http\Controllers;

use App\Reply;

class FavouritesController extends Controller
{
    /**
     * Create a new FavouritesController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Reply $reply
     * @return void
     */
    public function store(Reply $reply)
    {
        $reply->favourite();

        $reply->owner->gainReputation('reply_favourited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Reply $reply
     * @return void
     */
    public function destroy(Reply $reply)
    {
        $reply->unfavourite();

        $reply->owner->loseReputation('reply_favourited');
    }
}
