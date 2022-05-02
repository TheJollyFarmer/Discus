<?php
namespace Tests\Feature\Admin;

use App\Thread;
use App\User;
use App\Channel;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChannelAdministrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();

        $this->withExceptionHandling();
    }

    /** @test */
    public function anAdministratorCanAccessTheChannelAdministrationSection()
    {
        $this->signInAdmin()
             ->get(route('admin.channels.index'))
             ->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function nonAdministratorsCannotAccessTheChannelAdministrationSection()
    {
        $regularUser = create(User::class);

        $this->actingAs($regularUser)
             ->get(route('admin.channels.index'))
             ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->actingAs($regularUser)
             ->get(route('admin.channels.create'))
             ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function anAdministratorCanCreateAChannel()
    {
        $response = $this->createChannel([
            'name' => 'php',
            'description' => 'This is the channel for discussing all things PHP.',
            'color' => '#FF0000',
        ]);

        $this->get($response->headers->get('Location'))
             ->assertSee('php')
             ->assertSee('This is the channel for discussing all things PHP.');
    }

    /** @test */
    public function anAdministratorCanEditAnExistingChannel()
    {
        $this->signInAdmin();

        $this->patch(
            route('admin.channels.update', ['channel' => create(Channel::class)->slug]),
            $updatedChannel = [
                'name' => 'altered',
                'description' => 'altered channel description',
                'color' => '#00ff00',
                'archived' => true
            ]
        );

        $this->get(route('admin.channels.index'))
             ->assertSee($updatedChannel['name'])
             ->assertSee($updatedChannel['description']);
    }

    /** @test */
    public function anAdministratorCanMarkAnExistingChannelAsArchived()
    {
        $this->signInAdmin();

        $channel = create(Channel::class);

        $this->assertFalse($channel->archived);

        $this->patch(
            route('admin.channels.update', ['channel' => $channel->slug]),
            [
                'name' => 'altered',
                'description' => 'altered channel description',
                'color' => '#000000',
                'archived' => true
            ]
        );

        $this->assertTrue($channel->fresh()->archived);
    }

    /** @test */
    public function pathToThreadUnaffectedByChannelsArchivedStatus()
    {
        $thread = create(Thread::class);

        $path = $thread->path();

        $thread->channel->archive();

        $this->assertEquals($path, $thread->fresh()->path());
    }

    /** @test */
    public function anAdministratorCanEditAnArchivedChannel()
    {
        $this->signInAdmin();

        $channel = create(Channel::class, ['archived' => true]);

        $this->assertTrue($channel->archived);

        $this->get(route('admin.channels.edit', $channel))
             ->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function anAdministratorCanActivateArchivedChannel()
    {
        $this->signInAdmin();

        $channel = create(Channel::class, ['archived' => true]);

        $this->assertTrue($channel->archived);

        $this->patch(
            route('admin.channels.update', $channel),
            [
                'name' => 'altered',
                'description' => 'altered channel description',
                'color' => '#000000',
                'archived' => false
            ]
        );

        $this->assertFalse($channel->fresh()->archived);
    }

    /** @test */
    public function aChannelRequiresAName()
    {
        $this->createChannel(['name' => null])
             ->assertSessionHasErrors('name');
    }

    /** @test */
    public function aChannelRequiresADescription()
    {
        $this->createChannel(['description' => null])
             ->assertSessionHasErrors('description');
    }

    /** @test */
    public function aChannelRequiresAColor()
    {
        $this->createChannel(['color' => null])
             ->assertSessionHasErrors('color');
    }

    protected function createChannel($overrides = [])
    {
        $this->signInAdmin();

        $channel = make(Channel::class, $overrides);

        return $this->post(route('admin.channels.store'), $channel->toArray());
    }
}
