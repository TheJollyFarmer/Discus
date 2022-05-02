<?php

namespace App;

use Illuminate\Support\Facades\Redis;

class Visits
{
    /**
     * Thread instance.
     *
     * @property $thread
     */
    protected $thread;

    /**
     * Visits constructor.
     *
     * @param $thread
     */
    public function __construct($thread)
    {
        $this->thread = $thread;
    }

    /**
     * Increment the visit count for a thread on user visitation.
     *
     * @return $this
     */
    public function record()
    {
        Redis::incr($this->cacheKey());

        return $this;
    }

    /**
     * Reset the visits count for a thread.
     *
     * @return $this
     */
    public function reset()
    {
        Redis::del($this->cacheKey());

        return $this;
    }

    /**
     * Return the number of visits for a thread.
     *
     * @return int
     */
    public function count()
    {
        return Redis::get($this->cacheKey()) ?? 0;
    }

    /**
     * Fetch the cache key for a given thread.
     *
     * @return string
     */
    public function cacheKey()
    {
        return "threads.{$this->thread->id}.visits";
    }
}
