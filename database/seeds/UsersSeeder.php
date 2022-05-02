<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        collect([
            [
                'name' => 'Alice Doe',
                'username' => 'alicedoe',
                'email' => 'alice@example.com',
                'password' => bcrypt('password')
            ],
            [
                'name' => 'Jane Blow',
                'username' => 'jBlow',
                'email' => 'jane@example.com',
                'password' => bcrypt('password')
            ],
            [
                'name' => 'Spam',
                'username' => 'SpamDuster',
                'email' => 'spam@example.com',
                'password' => bcrypt('password')
            ],
            [
                'name' => 'The Genius',
                'username' => 'GZA',
                'email' => 'gza@example.com',
                'password' => bcrypt('password')
            ],
        ])->each(function ($user) {
            factory(User::class)->create(
                [
                    'name' => $user['name'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'password' => bcrypt('password')
                ]
            );
        });

        factory(User::class, 36)->create();
    }
}
