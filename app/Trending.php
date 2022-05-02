<?php

namespace App;

use Illuminate\Support\Facades\Redis;

class Trending
{
    /**
     * Fetch all trending threads.
     *
     * @return array
     */
    public function get()
    {
        return array_map('json_decode', Redis::zrevrange($this->cacheKey(), 0, 4));
    }

    /**
     * Push a new thread to the trending list.
     *
     * @param Thread $thread
     */
    public function push($thread)
    {
        Redis::zincrby($this->cacheKey(), 1, json_encode([
            'title' => $thread->title,
            'channel' => $thread->channel->slug,
            'slug' => $thread->slug
        ]));
    }

    /**
     * Remove a thread from the trending list.
     *
     * @param $thread
     */
    public function pop($thread)
    {
        Redis::zrem($this->cacheKey(), json_encode([
            'title' => $thread->title,
            'channel' => $thread->channel->slug,
            'slug' => $thread->slug
        ]));
    }

    /**
     * Reset all trending threads.
     */
    public function reset()
    {
        Redis::del($this->cacheKey());
    }

    /**
     * Get the cache key name.
     *
     * @return string
     */
    protected function cacheKey()
    {
        return 'trending_threads';
    }
}
