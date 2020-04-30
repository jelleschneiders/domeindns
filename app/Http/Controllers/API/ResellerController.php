<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUser;
use App\Notification;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Validator;

class ResellerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'reseller']);
    }

    public function store(CreateUser $request)
    {
        $user = User::create([
            'managed_by' => auth()->user()->id,
            'name' => ''.$request->get('first_name').' '.$request->get('last_name').'',
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'receive_notifications' => false,
            'email_verified_at' => Carbon::now(),
        ]);

        Notification::send(auth()->user()->id, 'success', 'user-plus', 'User '.$request->get('first_name').' '.$request->get('last_name').' added.');

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at,
            ],
        ]);
    }

    public function index()
    {
        $users = User::where('managed_by', auth()->user()->id)->select('id', 'name', 'email', 'created_at', 'updated_at')->get();

        return response()->json([
            'success' => true,
            'data' => $users,
        ]);
    }
}
