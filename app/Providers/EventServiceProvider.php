<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\ThreadReceivedNewReply' => [
            'App\Listeners\NotifyTaggedUsers',
            'App\Listeners\NotifySubscribers',
        ],
        'App\Events\UserHasNewFriend' => [
            'App\Listeners\NotifyNewFriend'
        ],
        Registered::class => [
            'App\Listeners\SendVerificationEmail'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
