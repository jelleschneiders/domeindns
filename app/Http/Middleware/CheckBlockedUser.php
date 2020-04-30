<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckBlockedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if ($user && $user->is_blocked) {
            Auth::logout();
            flash('Your account has been blocked. Please contact us at info@domeindns.nl')->error();
            return redirect('/login');
        }

        return $next($request);
    }
}
