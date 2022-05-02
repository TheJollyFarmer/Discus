<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use RefreshDatabase;

    public function testItHasAnOwner()
    {
        $reply = create('App\Reply');

        $this->assertInstanceOf('App\User', $reply->owner);
    }

    public function testItKnowsItWasJustPublished()
    {
        $reply = create('App\Reply');

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());
    }

    public function testItCanDetectAllMentionedUsersInTheBody()
    {
        $reply = new \App\Reply([
            'body' => '@JaneDoe wants to talk to @JohnDoe'
        ]);

        $this->assertEquals(['JaneDoe', 'JohnDoe'], $reply->taggedUsers());
    }

    public function testItWrapsMentionedUsernamesInTheBodyWithinAnchorTags()
    {
        $reply = new \App\Reply([
            'body' => 'Hello @JaneBlow'
        ]);

        $this->assertEquals(
            'Hello <a href="/profiles/JaneBlow">@JaneBlow</a>',
            $reply->body
        );
    }

    public function testItKnowsIfItIsMarkedAsTheBestReply()
    {
        $reply = create('App\Reply');

        $this->assertFalse($reply->isMarkedBest());

        $reply->thread->update(['best_reply_id' => $reply->id]);

        $this->assertTrue($reply->fresh()->isMarkedBest());
    }

    public function testARepliesBodyIsAutomaticallySanitised()
    {
        $reply = make('App\Reply', ['body' => '<script>alert("Bad Times!")</script><p>Good Times!</p>']);

        $this->assertEquals("<p>Good Times!</p>", $reply->body);
    }
}
