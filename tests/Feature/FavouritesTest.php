<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavouritesTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestsCanNotFavouriteAnything()
    {
        $this->withExceptionHandling()
            ->post('replies/1/favourites')
            ->assertRedirect('/login');
    }

    public function testAuthenticatedUserCanFavouriteAnyReply()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $this->post('replies/' . $reply->id . '/favourites');

        $this->assertCount(1, $reply->favourites);
    }

    public function testAuthenticatedUserCanUnfavouriteAnyReply()
    {
        $this->signIn();

        $reply = create('App\Reply');
        $reply->favourite();

        $this->delete('replies/' . $reply->id . '/favourites');
        $this->assertCount(0, $reply->favourites);
    }

    public function testAnAuthenticatedUserMayOnlyFavouriteAReplyOnce()
    {
        $this->signIn();

        $reply = create('App\Reply');

        try {
            $this->post('replies/' . $reply->id . '/favourites');
            $this->post('replies/' . $reply->id . '/favourites');
        } catch (\Exception $e) {
            $this->fail('Did not expect a duplicate record/favourite to be stored twice.');
        }

        $this->assertCount(1, $reply->favourites);
    }
}
