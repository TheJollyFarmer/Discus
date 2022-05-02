<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReplyRequest;
use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    /**
     * Create a new RepliesController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param         $channelId
     * @param Thread  $thread
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(Request $request, $channelId, Thread $thread)
    {
        return $thread->paginator();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  integer           $channelId
     * @param  Thread            $thread
     * @param CreateReplyRequest $form
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store($channelId, Thread $thread, CreateReplyRequest $form)
    {
        if ($thread->locked) {
            return response('Thread is locked', 422);
        }

        return $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id(),
            'parent_id' => request('parent_id', null),
            'favourites_total' => 0
        ])->load('owner');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reply $reply
     * @return array
     */
    public function show(Reply $reply)
    {
        if ($reply->parent_id) {
            $reply = Reply::find($reply->parent_id);
        }

        return $reply->linkData();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Reply $reply
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $this->validate(request(), ['body' => 'required|spamfree']);

        $reply->update(request(['body']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reply $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }
    }
}
