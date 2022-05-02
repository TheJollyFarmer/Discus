<?php

namespace App\Http\Controllers;

use App\Events\GroupCreated;
use App\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $offset = $request->query('offset');

            return auth()->user()
                         ->groups()
                         ->with('latestMessage')
                         ->limit(10)
                         ->offset($offset)
                         ->get();
        }

        return view("profiles.groups.index");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $type = $request->input('type');
        $users = $request->input('users');

        $group = auth()->user()->hasGroup($type, $users);

        if ($group->exists()) {
            return $group->first();
        }

        $group = Group::create([
            'name' => request('name'),
            'type' => $type
        ]);

        $group->addUsers($group, $users);

        return auth()->user()
                     ->groups()
                     ->where('group_id', $group->id)
                     ->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Group                    $group
     * @return \App\User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function update(Request $request, Group $group)
    {
        $users = collect(request('users'));

        $group->users()->attach($users);

        return $group->fresh()->users;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Group $group
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Group $group)
    {
        $group->users()->detach();
        $group->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Conversation deleted']);
        }
    }
}
