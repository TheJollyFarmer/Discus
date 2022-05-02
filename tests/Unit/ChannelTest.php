<?php

namespace Tests\Unit;

use App\Channel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Assert;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function aChannelConsistsOfThreads()
    {
        $channel = create('App\Channel');
        $thread = create('App\Thread', ['channel_id' => $channel->id]);

        $this->assertTrue($channel->threads->contains($thread));
    }

    /** @test */
    public function aChannelCanBeArchived()
    {
        $channel = create('App\Channel');
        $this->assertFalse($channel->archived);
        $channel->archive();
        $this->assertTrue($channel->archived);
    }

    /** @test */
    public function archivedChannelsAreExcludedByDefault()
    {
        create('App\Channel');
        create('App\Channel', ['archived' => true]);
        $this->assertEquals(1, Channel::count());
    }

    /** @test */
    public function channelsAreSortedAlphabeticallyByDefault()
    {
        $channelA = create('App\Channel', ['name' => 'PHP']);
        $channelB = create('App\Channel', ['name' => 'Basic']);
        $channelC = create('App\Channel', ['name' => 'Zsh']);

        $channels = Channel::all();

        $channels->assertEquals([
            $channelB,
            $channelA,
            $channelC,
        ]);
    }

    protected function setUp()
    {
        parent::setUp();

        Collection::macro('assertEquals', function ($items) {
            Assert::assertEquals(count($this), count($items));

            $this->zip($items)->each(function ($pair) {
                list($a, $b) = $pair;
                Assert::assertTrue($a->is($b));
            });
        });
    }
}
