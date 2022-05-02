<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscribeToThreadsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAUserCanSubscribeToAThread()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->post($thread->path() . "/subscriptions");
        $this->assertCount(1, $thread->subscriptions);
    }

    public function testAUserCanUnsubscribeFromAThread()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $thread->subscribe();

        $this->delete($thread->path() . "/subscriptions");

        $this->assertCount(0, $thread->subscriptions);
    }
}
