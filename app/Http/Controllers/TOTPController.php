<?php

namespace App\Http\Controllers;

use App\Http\Requests\VerifyTOTP;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TOTPController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $user = auth()->user();

        if (! $user->totp_status){
            return redirect('/home');
        }

        return view('auth.2fa');
    }

    public function verify(VerifyTOTP $request)
    {
        $user = auth()->user();

        $ga = new \PHPGangsta_GoogleAuthenticator();
        $checkResult = $ga->verifyCode($user->totp_token, $request->totp, 2);

        if (! $checkResult) {
            return back()->withErrors(['totp' => 'This TOTP code is not correct']);
        }

        $expirytime = Carbon::now()->addHours(12);
        \Session::put('2fa', $expirytime);

        return redirect('/home');
    }
}
