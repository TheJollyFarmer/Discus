<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('name');

        if (!$search) {
            $users = User::all();

            return $users->random(5)->all();
        }

        return User::where('username', 'LIKE', "$search%")
                   ->take(5)
                   ->get();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function authRouteAPI(Request $request)
    {
        return $request->user();
    }
}
