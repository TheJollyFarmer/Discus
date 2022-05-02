<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReputationTest extends TestCase
{
    use RefreshDatabase;

    protected $points = [];

    /**
     * Fetch current reputation points on class initialization.
     */
    public function setUp()
    {
        parent::setUp();
        $this->points = config('discus.reputation');
    }

    /** @test */
    public function AUserEarnsPointsWhenTheyCreateAThread()
    {
        $thread = create('App\Thread');

        $this->assertEquals($this->points['thread_published'], $thread->creator->reputation);
    }

    /** @test */
    public function AUserLosesPointsWhenTheyDeleteAThread()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->assertEquals($this->points['thread_published'], $thread->creator->reputation);

        $this->delete($thread->path());

        $this->assertEquals(0, $thread->creator->fresh()->reputation);
    }

    /** @test */
    public function AUserEarnsPointsWhenTheyReplyToAThread()
    {
        $thread = create('App\Thread');

        $reply = $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'A Reply'
        ]);

        $this->assertEquals($this->points['reply_posted'], $reply->owner->reputation);
    }

    /** @test */
    public function AUserLosesPointsWhenTheirReplyToAThreadIsDeleted()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->assertEquals($this->points['reply_posted'], $reply->owner->reputation);

        $this->delete(route('replies.destroy', $reply->id));

        $this->assertEquals(0, $reply->owner->fresh()->reputation);
    }

    /** @test */
    public function AUserEarnsPointsWhenTheirReplyIsMarkedAsBest()
    {
        $thread = create('App\Thread');

        $thread->markBestReply($reply = $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'Here is a reply.'
        ]));

        $total = $this->points['reply_posted'] + $this->points['best_reply_awarded'];
        $this->assertEquals($total, $reply->owner->reputation);
    }

    /** @test */
    public function AUserLosesPointsWhenTheirBestReplyIsDeleted()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $reply->thread->markBestReply($reply);

        $total = $this->points['reply_posted'] + $this->points['best_reply_awarded'];

        $this->assertEquals($total, auth()->user()->fresh()->reputation);

        $reply->delete();

        $this->assertEquals(0, auth()->user()->fresh()->reputation);
    }

    /** @test */
    public function whenAThreadOwnerChangesTheirChosenBestReplyThePointsAreTransferred()
    {
        $thread = create('App\Thread');

        $jane = create('App\User');

        $thread->markBestReply($thread->addReply([
            'user_id' => $jane->id,
            'body' => 'Here is a reply.'
        ]));

        $this->assertEquals(
            $this->points['reply_posted'] + $this->points['best_reply_awarded'],
            $jane->fresh()->reputation
        );

        $john = create('App\User');

        $thread->markBestReply($thread->addReply([
            'user_id' => $john->id,
            'body' => 'Here is a better reply.'
        ]));

        $this->assertEquals($this->points['reply_posted'], $jane->fresh()->reputation);

        $total = $this->points['reply_posted'] + $this->points['best_reply_awarded'];

        $this->assertEquals($total, $john->fresh()->reputation);
    }

    /** @test */
    public function AUserGainsPointsWhenTheirReplyIsFavourited()
    {
        $this->signIn($john = create('App\User'));

        $jane = create('App\User');

        $reply = create('App\Thread')->addReply([
            'user_id' => $jane->id,
            'body' => 'Some reply'
        ]);

        $this->post(route('favourites.store', $reply));

        $this->assertEquals(
            $this->points['reply_posted'] + $this->points['reply_favourited'],
            $jane->fresh()->reputation
        );

        $this->assertEquals(0, $john->reputation);
    }

    /** @test */
    public function aUserLosesPointsWhenTheirReplyIsUnfavourited()
    {
        $this->signIn($john = create('App\User'));

        $jane = create('App\User');

        $reply = create('App\Reply', ['user_id' => $jane]);

        $this->post(route('favourites.store', $reply));

        $this->assertEquals(
            $this->points['reply_posted'] + $this->points['reply_favourited'],
            $jane->fresh()->reputation
        );

        $this->delete(route('favourites.destroy', $reply));

        $this->assertEquals($this->points['reply_posted'], $jane->fresh()->reputation);

        $this->assertEquals(0, $john->reputation);
    }
}
