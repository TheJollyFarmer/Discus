<?php

namespace App\Http\Controllers;

use App\Events\UserHasNewFriend;
use App\Events\UserHasNewFriendRequest;
use App\Friendship;
use App\User;
use Illuminate\Http\Request;

class FriendshipsController extends Controller
{
    /**
     * ThreadController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param User    $user
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, Request $request)
    {
        if ($request->wantsJson()) {
            $offset = $request->query('offset');

            if ($request->query('type')) {
                return $user->friendRequests()
                            ->orderBy('friendships.created_at', 'desc')
                            ->limit(10)
                            ->offset($offset)
                            ->get();
            }

            return $user->friends;
        }

        return view("profiles.friendrequests.index");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param User                     $user
     * @param \Illuminate\Http\Request $request
     * @return Friendship|\Illuminate\Database\Eloquent\Model
     */
    public function store(User $user, Request $request)
    {
        $friendship = Friendship::create([
            'first_user' => auth()->id(),
            'second_user' => $user->id,
            'acted_user' => auth()->id(),
            'status' => 'pending'
        ]);

        event(new UserHasNewFriendRequest($user, $friendship));

        return $friendship;
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user->friendStatus();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Friendship $friendship
     * @return \Illuminate\Http\Response
     */
    public function update(Friendship $friendship)
    {
        $friendship->update([
            'acted_user' => auth()->id(),
            'status' => 'confirmed'
        ]);

        event(new UserHasNewFriend($friendship));

        if (request()->expectsJson()) {
            return response(['status' => 'Friendship confirmed', 'test' => $friendship]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Friendship $friendship
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Friendship $friendship)
    {
        $friendship->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Friendship deleted']);
        }
    }
}
