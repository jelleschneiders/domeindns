<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUser;
use App\Http\Requests\EditResellerUser;
use App\Notification;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResellerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'two_factor', 'reseller']);
    }

    public function index()
    {
        $users = User::where('managed_by', auth()->user()->id)->get();

        return view('reseller.users', compact('users'));
    }

    public function show(string $id)
    {
        $user = $this->checkUser($id);

        return view('reseller.userdashboard', compact('user'));
    }

    public function blockUser(string $id)
    {
        $user = $this->checkUser($id);

        $attribute['is_blocked'] = true;

        if($user->is_blocked){
            $attribute['is_blocked'] = false;
        }

        $user->update($attribute);

        return back();
    }

    public function login(string $id)
    {
        $user = $this->checkUser($id);

        \Auth::loginUsingId($user->id);

        \Session::put('logged_in_as', true);

        return redirect('/home');
    }

    public function showCreate()
    {
        return view('reseller.create');
    }

    public function store(CreateUser $request)
    {
        if($request->get('password') === $request->get('password_confirmation')){
            $user = User::create([
                'managed_by' => auth()->user()->id,
                'name' => ''.$request->get('first_name').' '.$request->get('last_name').'',
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'receive_notifications' => false,
                'email_verified_at' => Carbon::now(),
            ]);

            Notification::send(auth()->user()->id, 'success', 'user-plus', 'User '.$request->get('first_name').' '.$request->get('last_name').' added.');

            return redirect('/reseller/users/'.$user->id);
        }

        return back()->withErrors(['password' => 'The passwords don\'t match.']);
    }

    public function destroy(string $id)
    {
        $user = $this->checkUser($id);

        if($user->zones->count() != 0 || $user->tags->count() != 0 || $user->templates->count() != 0){
            flash('There are still domains/templates/tags in this account. Please delete all of them first before deleting this account.');
            return redirect('/reseller/users/'.$user->id);
        }

        $user->delete();

        flash('This account has been permanently deleted from our database.');
        return redirect('/reseller/users');
    }

    public function showedit(string $id)
    {
        $user = $this->checkUser($id);

        return view('reseller.edit', compact('user'));
    }

    public function edit(EditResellerUser $request)
    {
        $user = $this->checkUser($request->id);

        if(isset($request->password)){
            $user->password = Hash::make($request->password);
        }
        $user->name = $request->get('name');
        $user->save();

        flash('User edited.');

        return redirect('/reseller/users/'.$user->id);
    }

    public function reset2fa(string $id)
    {
        $user = $this->checkUser($id);

        $user->totp_status = false;
        $user->update();

        flash('2FA has been disabled for this account.');

        return redirect('/reseller/users/'.$user->id);
    }

    public function checkUser($id)
    {
        $user = User::where([
            ['id', $id],
            ['managed_by', auth()->user()->id]
        ])->firstOrFail();

        return $user;
    }
}
