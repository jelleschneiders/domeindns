<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'two_factor']);
    }

    public function logout()
    {
        if(!\Session::has('logged_in_as')) {
            abort(404);
        }

        $currentuserid = auth()->user()->id;

        $user = auth()->user()->managed_by;

        \Auth::loginUsingId($user);

        \Session::forget('logged_in_as');

        return redirect('/reseller/users/'.$currentuserid);
    }
}
