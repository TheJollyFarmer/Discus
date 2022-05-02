<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserNotificationsController extends Controller
{
    /**
     * Create a new RepliesController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $offset = $request->query('offset');

            return [
                'count' => auth()->user()->unreadNotifications->count(),
                'notifications' => auth()->user()
                                         ->notifications()
                                         ->limit(10)
                                         ->offset($offset)
                                         ->get()
            ];
        }

        return view("profiles.notifications.index");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User                $user
     * @param int                      $id
     * @return void
     */
    public function update(Request $request, User $user, $id)
    {
        if ($request->query('unmark')) {
            return auth()->user()
                         ->notifications()
                         ->findOrFail($id)
                         ->markAsUnread();
        }

        auth()->user()
              ->notifications()
              ->findOrFail($id)
              ->markAsRead();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        return auth()->user()->unreadNotifications->markAsRead();
    }
}
