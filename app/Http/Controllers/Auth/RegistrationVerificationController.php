<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;

class RegistrationVerificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('verification_token', request('token'))->first();
        $message = 'Verification failed due to an invalid token.';

        if (!$user) {
            return redirect(route('threads.index'))->with('flash', $message);
        }
        $user->verify();

        return redirect()
            ->route('threads.index')
            ->with('flash', 'Your account is now verified. Enjoy!');
    }
}
