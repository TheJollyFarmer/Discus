<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Filters\ThreadFilter;
use App\Rules\Recaptcha;
use App\Thread;
use App\Trending;
use Illuminate\Http\Request;

class ThreadsController extends Controller
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
     * @param Channel                  $channel
     * @param ThreadFilter             $filter
     * @param Trending                 $trending
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, ThreadFilter $filter, Trending $trending, Request $request)
    {
        if (request()->wantsJson()) {
            $offset = $request->query('offset');
            $threads = Thread::getThreads($channel, $filter, $offset);

            return response()->json($threads);
        } else {
            return view('threads.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Rules\Recaptcha     $recaptcha
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Recaptcha $recaptcha)
    {
        $this->validate($request, [
            'title' => 'required|spamfree',
            'body' => 'required|spamfree',
            'channel_id' => 'required|exists:channels,id',
            'g-recaptcha-response' => ['required', $recaptcha]
        ]);

        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body')
        ]);

        return response($thread->path(), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param integer     $channel
     * @param \App\Thread $thread
     * @param Trending    $trending
     * @param Request     $request
     * @return \Illuminate\Http\Response
     */
    public function show($channel, Thread $thread, Trending $trending, Request $request)
    {
        if (auth()->check()) {
            auth()->user()->read($thread);
        }

        $trending->push($thread);
        $thread->visits()->record();

        return view('threads.show', compact('thread'));
    }

    /**
     * Update the given thread.
     *
     * @param string $channel
     * @param Thread $thread
     * @return \App\Thread
     */
    public function update($channel, Thread $thread)
    {
        $this->authorize('update', $thread);

        $thread->update(request()->validate([
            'title' => 'required',
            'body' => 'required'
        ]));

        return $thread;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param integer     $channel
     * @param \App\Thread $thread
     * @param Trending    $trending
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($channel, Thread $thread, Trending $trending)
    {
        $this->authorize('update', $thread);

        $thread->delete();
        $trending->pop($thread);

        return response([], 204);
    }
}
