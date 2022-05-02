<?php

use App\Conversation;
use App\Events\UserHasNewFriendRequest;
use App\Friendship;
use App\Group;
use App\User;
use Illuminate\Database\Seeder;

class FriendsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Friendship::truncate();
        Group::truncate();
        Conversation::truncate();

        factory(Group::class, 15)->create()->each(function ($group) {
            $friend = User::where('name', '=', $group->name)->first();
            $users = [1, $friend->id];

            $group->users()->attach($users);

            factory(Conversation::class, 10)
                ->states('from_existing_users_and_groups')
                ->create(['user_id' => $friend->id]);
        });

        factory(Friendship::class, 15)->states('from_existing_users_pending')->create()->each(function ($friendship) {
            $user = User::find(1);

            event(new UserHasNewFriendRequest($user, $friendship));
        });

        factory(Friendship::class, 10)->states('from_existing_users_confirmed')->create();
        factory(Conversation::class, 150)->states('from_existing_groups_and_primary_user')->create();
    }
}
