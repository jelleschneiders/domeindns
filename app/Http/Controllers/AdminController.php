<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendNotification;
use App\Notification;
use App\ResellerRequest;
use App\Tag;
use App\Template;
use App\User;
use App\Zone;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'two_factor', 'is_admin']);
    }

    public function userIndex()
    {
        $users = User::all();
        $zones = Zone::all()->count();
        $templates = Template::all()->count();
        $tags = Tag::all()->count();

        return view('admin.users.index', compact('users', 'zones', 'templates', 'tags'));
    }

    public function userView(string $id)
    {
        $user = User::where('id', $id)->firstOrFail();

        return view('admin.user.dashboard', compact('user'));
    }

    public function blockUser(string $id)
    {
        $user = User::where('id', $id)->firstOrFail();

        $attribute['is_blocked'] = true;

        if($user->is_blocked){
            $attribute['is_blocked'] = false;
        }

        $user->update($attribute);

        return back();
    }

    public function notifyUserindex(string $id)
    {
        $user = User::where('id', $id)->firstOrFail();

        return view('admin.notification.form', compact('user'));
    }

    public function notifyUserstore(SendNotification $request)
    {
        $user = User::where('id', $request->id)->firstOrFail();

        $notification['user_id'] = $user->id;
        $notification['type'] = $request->get('type');
        $notification['icon'] = $request->get('icon');
        $notification['text'] = $request->get('text');
        Notification::create($notification);

        flash('Notification has been sent to the user');

        return redirect('/admin/users/'.$user->id);
    }

    public function resellerUser(string $id)
    {
        $user = User::where('id', $id)->firstOrFail();

        $attribute['reseller'] = true;

        if($user->reseller){
            $attribute['reseller'] = false;
        }

        $user->update($attribute);

        return back();
    }

    public function resellerRequestOverview()
    {
        $requests = ResellerRequest::where('handled', false)->get();

        return view('admin.reseller.requests', compact('requests'));
    }

    public function updateResellerRequest(Request $request)
    {
        $resellerrequest = ResellerRequest::where([
            ['id', $request->reqid],
            ['handled', false]
        ])->firstOrFail();

        $attribute['handled'] = true;
        $resellerrequest->update($attribute);

        Notification::send($resellerrequest->user_id, 'info', 'user-friends', 'We have processed your request for reseller access. Check the reseller page if we have granted you access to this service.');

        return back();
    }

    public function login(string $id)
    {
        $user = User::where([
            ['id', $id],
            ['allow_support', true]
        ])->firstOrFail();

        \Auth::loginUsingId($user->id);

        \Session::put('logged_in_as', true);

        return redirect('/home');
    }
}
