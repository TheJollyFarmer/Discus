<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadThreadsTest extends TestCase
{
    use RefreshDatabase;

    protected $thread;

    public function setUp()
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    public function testUserCanViewAllThreads()
    {
        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    public function testUserCanReadSingleThread()
    {
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    public function testUserCanReadRepliesThatAreAssociatedWithAThread()
    {
        $reply = factory('App\Reply')
            ->create(['thread_id' => $this->thread->id]);

        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
    }

    public function testUserCanFilterThreadsAccordingToAChannel()
    {
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    public function testUserCanFilterThreadsByAnyUsername()
    {
        $this->signIn(create('App\User', ['name' => 'JohnDoe']));

        $threadByJohn = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotByJohn = create('App\Thread');

        $this->get('threads?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }

    public function testUserCanFilterThreadsByPopularity()
    {
        $firstThread = factory('App\Thread')->create(['title' => 'DISCUS 1']);
        create('App\Reply', ['thread_id' => $firstThread->id], 3);

        $secondThread = factory('App\Thread')->create(['title' => 'DISCUS 2']);
        create('App\Reply', ['thread_id' => $secondThread->id], 2);

        $this->thread;

        $response = $this->get('threads?popular=1');
        $threadsFromResponse = $response->baseResponse->original->getData()['threads'];

        $this->assertEquals([3, 2, 0], $threadsFromResponse->pluck('replies_count')->toArray());
    }

    public function testGuestCanFilterThreadsAndThreadCanStillSortByTime()
    {
        $firstThread = factory('App\Thread')->create(['title' => 'DISCUS 2', 'created_at' => new Carbon('-2 minutes')]);
        create('App\Reply', ['thread_id' => $firstThread->id], 3);

        $secondThread = factory('App\Thread')->create(['title' => 'DISCUS 1', 'created_at' => new Carbon('-1 minute')]);
        create('App\Reply', ['thread_id' => $secondThread->id], 3);

        $response = $this->get('threads?popular=1');
        $threadsFromResponse = $response->baseResponse->original->getData()['threads'];

        $this->assertEquals(['DISCUS 1', 'DISCUS 2'], $threadsFromResponse->pluck('title')->take(2)->all());
    }

    public function AUserCanFilterThreadsByThoseThatAreUnanswered()
    {
        $thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $thread->id]);

        // Test does not work because SQlite requires a groupBy method before the having method.
        // This is superfluous when using SQL.
        $response = $this->getJson('threads?unanswered=1')->json();

        $this->assertCount(1, $response);
    }

    public function testUserCanRequestAllRepliesForAGivenThread()
    {
        $thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $thread->id], 20);

        $response = $this->getJson($thread->path() . '/replies')->json();

        $this->assertCount(15, $response['paginator']['data']);
        $this->assertEquals(20, $response['paginator']['total']);
    }
}
