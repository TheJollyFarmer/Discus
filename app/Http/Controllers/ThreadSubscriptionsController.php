<?php

namespace App\Http\Controllers;

use App\Thread;

class ThreadSubscriptionsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param        $channelId
     * @param Thread $thread
     * @return void
     */
    public function store($channelId, Thread $thread)
    {
        $thread->subscribe();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param        $channelId
     * @param Thread $thread
     * @return void
     */
    public function destroy($channelId, Thread $thread)
    {
        $thread->unsubscribe();
    }
}
