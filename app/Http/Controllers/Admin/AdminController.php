<?php

namespace App\Http\Controllers\Admin;

use App\Channel;
use App\Http\Controllers\Controller;
use App\Thread;

class AdminController extends Controller
{
    /**
     * Show the admin page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $channels = Channel::withArchived()->get();
        $threads = Thread::all();

        return view('admin.index', compact('channels', 'threads'));
    }
}