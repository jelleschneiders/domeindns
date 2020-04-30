<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'two_factor']);
    }

    public function index()
    {
        return view('notifications.list', [
            'notifications' => auth()->user()->notifications->sortByDesc('created_at')
        ]);
    }

    public function show(string $id)
    {
        $notification = Notification::where([
            ['user_id', '=', auth()->user()->id],
            ['id', '=', $id]
        ])->firstOrFail();

        $notification->update(['seen' => true]);

        return back();
    }

    public function destroy(string $id)
    {
        $notification = Notification::where([
            ['user_id', '=', auth()->user()->id],
            ['id', '=', $id]
        ])->firstOrFail();

        $notification->delete();

        return redirect('/notifications');
    }
}
