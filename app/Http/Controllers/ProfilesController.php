<?php

namespace App\Http\Controllers;

use App\Activity;
use App\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    /**
     * Fetch the user's activity feed.
     * @#param User $user
     *
     * @param \App\User                $user
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(User $user, Request $request)
    {
        $offset = $request->query('offset');

        return Activity::feed($user, $offset);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('profiles.show', ['profileUser' => $user]);
    }
}
