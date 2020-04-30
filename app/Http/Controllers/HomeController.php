<?php

namespace App\Http\Controllers;

use App\LoginLog;
use App\Notification;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'two_factor']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();

        $loginlogs = LoginLog::where([
            ['user_id', '=', auth()->user()->id]
        ])->latest()->limit(10)->get();

        $notifications = Notification::where([
            ['user_id', '=', auth()->user()->id]
        ])->latest()->limit(10)->get();

        return view('home', compact('user', 'loginlogs', 'notifications'));
    }
}
