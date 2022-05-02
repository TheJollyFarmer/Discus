<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfUserNotVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if (! $user->verified && ! $user->isAdmin()) {
            return redirect('/')->with('flash', 'You must first confirm your email address.');
        }
        return $next($request);
    }
}
