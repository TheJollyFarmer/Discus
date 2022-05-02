<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\Events\UserSentMessage;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Conversation|\Illuminate\Database\Eloquent\Model
     */
    public function store(Request $request)
    {
        $conversation = Conversation::create([
            'message' => request('message'),
            'group_id' => request('group'),
            'user_id' => auth()->user()->id,
        ]);

        broadcast(new UserSentMessage($conversation))->toOthers();

        return $conversation->load('user');
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param                          $group
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $group)
    {
        $offset = $request->query('offset');

        return Conversation::where('group_id', $group)
                           ->latest()
                           ->offset($offset)
                           ->take(10)
                           ->get()
                           ->reverse()
                           ->values();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Conversation $conversation
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Conversation $conversation)
    {
        //$this->authorize('update', $thread);

        $conversation->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }
    }
}
