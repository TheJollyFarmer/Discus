<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'username' => $faker->unique()->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'verified' => true
    ];
});

$factory->state(App\User::class, 'unverified', function () {
    return [
        'verified' => false
    ];
});

$factory->define(App\Thread::class, function ($faker) {
    $title = $faker->sentence;

    return [
        'user_id' => function () {
            return factory(\App\User::class)->create()->id;
        },
        'channel_id' => function () {
            return factory(\App\Channel::class)->create()->id;
        },
        'title' => $title,
        'body' => $faker->paragraph,
        'slug' => str_slug($title),
        'locked' => false
    ];
});

$factory->state(App\Thread::class, 'from_existing_channels_and_users', function ($faker) {
    $title = $faker->sentence;

    return [
        'user_id' => function () {
            return \App\User::all()->random()->id;
        },
        'channel_id' => function () {
            return \App\Channel::all()->random()->id;
        },
        'title' => $title,
        'body' => $faker->paragraph,
        'slug' => str_slug($title),
        'locked' => $faker->boolean(15)
    ];
});

$factory->define(App\ThreadSubscription::class, function ($faker) {
    $threads = \App\Thread::where('id', '>', 0)->pluck('id')->toArray();
    $thread = $faker->unique()->randomElement($threads);

    return [
        'user_id' => function () {
            return \App\User::where('id', '=', 1)->first()->id;
        },
        'thread_id' => $thread
    ];
});

$factory->define(App\Channel::class, function ($faker) {
    return [
        'name' => $faker->unique()->word,
        'description' => $faker->sentence,
        'archived' => false,
        'color' => $faker->hexcolor
    ];
});

$factory->define(App\Reply::class, function ($faker) {
    return [
        'thread_id' => function () {
            return factory(\App\Thread::class)->create()->id;
        },
        'user_id' => function () {
            return factory(\App\User::class)->create()->id;
        },
        'favourites_total' => $faker->numberBetween($min = 0, $max = 30),
        'body' => $faker->paragraph
    ];
});

$factory->state(App\Reply::class, 'from_existing_threads_and_users', function ($faker) {
    return [
        'thread_id' => function () {
            return \App\Thread::all()->random()->id;
        },
        'user_id' => function () {
            return \App\User::all()->random()->id;
        },
        'favourites_total' => $faker->numberBetween($min = 0, $max = 30),
        'body' => $faker->paragraph
    ];
});

$factory->state(App\Reply::class, 'child_from_existing_threads_and_users', function ($faker) {
    return [
        'thread_id' => function () {
            return \App\Thread::all()->random()->id;
        },
        'user_id' => function () {
            return \App\User::all()->random()->id;
        },
        'parent_id' => function () {
            return \App\Reply::all()->random()->id;
        },
        'favourites_total' => $faker->numberBetween($min = 0, $max = 30),
        'body' => $faker->paragraph
    ];
});

$factory->define(App\Friendship::class, function ($faker) {
    return [
        'first_user' => function () {
            return factory(\App\User::class)->create()->id;
        },
        'second_user' => function () {
            return factory(\App\User::class)->create()->id;
        },
        'acted_user' => function () {
            return factory(\App\User::class)->create()->id;
        },
        'status' => 'pending'
    ];
});

$factory->state(App\Friendship::class, 'from_existing_users_pending', function ($faker) {
    $friends = \App\User::where('id', '>', 20)->pluck('id')->toArray();
    $friend = $faker->unique()->randomElement($friends);

    return [
        'first_user' => $friend,
        'second_user' => function () {
            return \App\User::where('id', '=', 1)->first()->id;
        },
        'acted_user' => $friend,
        'status' => 'pending'
    ];
});

$factory->state(App\Friendship::class, 'from_existing_users_confirmed', function ($faker) {
    $friends = \App\User::where('id', '<=', 20)->pluck('id')->toArray();

    return [
        'first_user' => $faker->unique()->randomElement($friends),
        'second_user' => function () {
            return \App\User::where('id', '=', 1)->first()->id;
        },
        'acted_user' => function () {
            return \App\User::where('id', '=', 1)->first()->id;
        },
        'status' => 'confirmed'
    ];
});

$factory->define(App\Group::class, function ($faker) {
    $friends = \App\User::whereBetween('id', [2, 16])->pluck('name')->toArray();
    $friend = $faker->unique()->randomElement($friends);

    return [
        'name' => $friend
    ];
});

$factory->define(App\Conversation::class, function ($faker) {
    return [
        'message' => $faker->sentence,
        'user_id' => function () {
            return factory(\App\User::class)->create()->id;
        },
        'group_id' => function () {
            factory(\App\Group::class)->create()->id;
        }
    ];
});

$factory->state(App\Conversation::class, 'from_existing_users_and_groups', function ($faker) {
    return [
        'message' => $faker->sentence,
        'user_id' => function () {
            return \App\User::all()->random()->id;
        },
        'group_id' => function () {
            return \App\Group::all()->random()->id;
        },
    ];
});

$factory->state(App\Conversation::class, 'from_existing_groups_and_primary_user', function ($faker) {
    return [
        'message' => $faker->sentence,
        'user_id' => function () {
            return \App\User::where('id', '=', 1)->first()->id;
        },
        'group_id' => function () {
            return \App\Group::all()->random()->id;
        },
    ];
});

$factory->define(\Illuminate\Notifications\DatabaseNotification::class, function ($faker) {
    return [
        'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
        'type' => \App\Notifications\ThreadWasUpdated::class,
        'notifiable_id' => function () {
            return auth()->id() ?: factory(\App\User::class)->create()->id;
        },
        'notifiable_type' => \App\User::class,
    ];
});
