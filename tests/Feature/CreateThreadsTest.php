<?php

namespace Tests\Feature;

use App\Rules\Recaptcha;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        app()->singleton(Recaptcha::class, function () {
            return \Mockery::mock(Recaptcha::class, function ($m) {
                $m->shouldReceive('passes')->andReturn(true);
            });
        });
    }

    public function testGuestsMayNotCreateThreads()
    {
        $this->withExceptionHandling();

        $this->post(route('threads.index'))->assertStatus(302)->assertRedirect(route('login'));
    }

    public function testNewUsersMustFirstConfirmTheirEmailAddressBeforeCreatingThreads()
    {
        $user = factory('App\User')->states('unverified')->create();

        $this->signIn($user);

        $thread = make('App\Thread');

        $this->post(route('threads.index'), $thread->toArray())
             ->assertRedirect(route('threads.index'))
             ->assertSessionHas('flash', 'You must first confirm your email address.');
    }

    public function testAuthenticatedUserCanCreateNewForumThreads()
    {
        $this->signIn();

        $thread = make('App\Thread');

        $response = $this->post(
            route('threads.store'),
            $thread->toArray() + ['g-recaptcha-response' => 'token']
        );

        $this->get($response->headers->get('Location'))
             ->assertSee($thread->title)
             ->assertSee($thread->body);
    }

    public function testThreadRequiresATitle()
    {
        $this->publishThread(['title' => null])
             ->assertSessionHasErrors('title');
    }

    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread', $overrides);

        return $this->post(route('threads.store'), $thread->toArray());
    }

    public function testThreadRequiresABody()
    {
        $this->publishThread(['body' => null])
             ->assertSessionHasErrors('body');
    }

    public function testThreadRequiresAValidChannel()
    {
        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => null])
             ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
             ->assertSessionHasErrors('channel_id');
    }

    public function testThreadRequiresAUniqueSlug()
    {
        $this->signIn();

        $thread = create('App\Thread', ['title' => 'Foo Title']);

        $this->assertEquals($thread->slug, 'foo-title');

        $thread = $this->postJson(
            route('threads.store'),
            $thread->toArray() + ['g-recaptcha-response' => 'token']
        )->json();

        $this->assertEquals("foo-title-{$thread['id']}", $thread['slug']);
    }

    public function testThreadWithTitleThatEndsInNumberShouldGenerateCorrectSlug()
    {
        $this->signIn();

        $thread = create('App\Thread', ['title' => 'Foo Title 24']);

        $thread = $this->postJson(
            route('threads.store'),
            $thread->toArray() + ['g-recaptcha-response' => 'token']
        )->json();

        $this->assertEquals("foo-title-24-{$thread['id']}", $thread['slug']);
    }

    public function testAThreadRequiresRecaptchaVerification()
    {
        unset(app()[Recaptcha::class]);

        $this->publishThread(['g-recaptcha-response' => 'test'])
             ->assertSessionHasErrors('g-recaptcha-response');
    }
}
