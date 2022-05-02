<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagUserTest extends TestCase
{
    use RefreshDatabase;

    public function testUsersTaggedInAReplyAreNotified()
    {
        $alice = create('App\User', ['name' => 'Alice Doe']);
        $jane = create('App\User', ['name' => 'JaneBlow']);

        $this->signIn($alice);

        $thread = create('App\Thread');
        $reply = make('App\Reply', [
            'body' => 'Hey @JaneBlow check this out!'
        ]);

        $this->json('post', $thread->path() . '/replies', $reply->toArray());

        $this->assertCount(1, $jane->notifications);
    }

    public function testItCanFetchAllMentionedUsersStartingWithTheGivenCharacters()
    {
        create('App\User', ['name' => 'john doe']);
        create('App\User', ['name' => 'john hamm']);
        create('App\User', ['name' => 'jane doe']);

        $results = $this->json('GET', 'api/users', ['name' => 'john']);

        $this->assertCount(2, $results->json());
    }
}
