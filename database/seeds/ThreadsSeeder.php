<?php

use App\Activity;
use App\Channel;
use App\Events\ThreadReceivedNewReply;
use App\Favourite;
use App\Reply;
use App\Thread;
use App\ThreadSubscription;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ThreadsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $this->channels()->content();

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Seed the thread-related tables.
     */
    protected function content()
    {
        Thread::truncate();
        Reply::truncate();
        ThreadSubscription::truncate();
        Activity::truncate();
        Favourite::truncate();

        factory(Thread::class, 50)->states('from_existing_channels_and_users')
                                  ->create()
                                  ->each(function ($thread) {
                                      $this->recordActivity($thread, 'created', $thread->creator()->first()->id);
                                  });

        factory(ThreadSubscription::class, 5)->create();

        factory(Reply::class, 500)->states('from_existing_threads_and_users')
                                  ->create()
                                  ->each(function ($reply) {
                                      $this->recordActivity($reply, 'created', $reply->owner()->first()->id);
                                      event(new ThreadReceivedNewReply($reply));
                                  });

        factory(Reply::class, 200)->states('child_from_existing_threads_and_users')
                                  ->create()
                                  ->each(function ($reply) {
                                      $this->recordActivity($reply, 'created', $reply->owner()->first()->id);
                                  });
    }

    /**
     * @param $model
     * @param $event_type
     * @param $user_id
     * @throws ReflectionException
     */
    public function recordActivity($model, $event_type, $user_id)
    {
        $type = strtolower((new \ReflectionClass($model))->getShortName());

        $model->morphMany(Activity::class, 'subject')->create([
            'user_id' => $user_id,
            'type' => "{$event_type}_{$type}"
        ]);
    }

    /**
     * Seed the channels table.
     */
    protected function channels()
    {
        Channel::truncate();

        collect([
            [
                'name' => 'PHP',
                'description' => 'A channel for general PHP questions.',
                'color' => '#008000'
            ],
            [
                'name' => 'Vue',
                'description' => 'A channel for general Vue questions.',
                'color' => '#cccccc'
            ],
            [
                'name' => 'Laravel Mix',
                'description' => 'This channel is for all Laravel Mix related questions.',
                'color' => '#43DDF5'
            ],
            [
                'name' => 'Eloquent',
                'description' => 'This channel is for all Laravel Eloquent related questions.',
                'color' => '#a01212'
            ],
            [
                'name' => 'Vuex',
                'description' => 'This channel is for all Vuex related questions.',
                'color' => '#ff8822'
            ],
        ])->each(function ($channel) {
            factory(Channel::class)->create([
                'name' => $channel['name'],
                'description' => $channel['description'],
                'color' => $channel['color']
            ]);
        });

        return $this;
    }
}
