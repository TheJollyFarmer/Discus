<?php

namespace App\Http\Controllers\Admin;

use App\Channel;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class ChannelsController extends Controller
{
    /**
     * Store a new channel.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $channel = Channel::create(
            request()->validate([
                'name' => 'required|unique:channels',
                'color' => 'required',
                'description' => 'required',
            ])
        );

        cache()->forget('channels');

        return response($channel, 201);
    }

    /**
     * Update an existing channel.
     *
     * @param \App\Channel $channel
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function update(Channel $channel)
    {
        $channel->update(
            request()->validate([
                'name' => ['required', Rule::unique('channels')->ignore($channel->id)],
                'description' => 'required',
                'color' => 'required',
                'archived' => 'required|boolean'
            ])
        );

        cache()->forget('channels');

        return response($channel, 200);
    }
}