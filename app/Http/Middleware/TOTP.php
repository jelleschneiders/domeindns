<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Session;

class TOTP
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

        if ($user->totp_status) {
            $get2fa = \Session::get('2fa');
            $time = Carbon::now();

            if (! $get2fa || $get2fa < $time) {
                return redirect('/2fa');
            }
        }

        return $next($request);
    }
}
