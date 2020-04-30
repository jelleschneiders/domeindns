<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestReseller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateUserSettings;
use App\Http\Requests\VerifyPassword;
use App\Http\Requests\VerifyTOTP;
use App\Jobs\DeleteZone;
use App\ResellerRequest;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'two_factor']);
    }

    public function destroy(VerifyPassword $request){
        $user = auth()->user();

        if(isset($user->managed_by)){
            abort(404);
        }

        if (!Hash::check($request->current, $user->password)) {
            return back()->withErrors(['current' => 'The current password is incorrect.']);
        }

        if(auth()->user()->zones->count() != 0 || auth()->user()->tags->count() != 0 || auth()->user()->templates->count() != 0){
            flash('There are still domains/templates/tags in your account. Please delete all of them first before deleting your account.');
            return redirect('/account/delete');
        }

        foreach (auth()->user()->zones as $zone){
            $zone['status'] = Status::$PENDING_DELETION;
            $zone->update();
            DeleteZone::dispatch($zone);
        }

        $user->delete();

        flash('Your account has been permanently deleted from our database.');

        return redirect('/login');
    }

    public function updatePassword(UpdatePasswordRequest $request){
        $user = auth()->user();

        if (!Hash::check($request->current, $user->password)) {
            return back()->withErrors(['current' => 'The current password is incorrect.']);
        }

        if ($request->new === $request->newconfirm) {
            $user->password = Hash::make($request->new);
            $user->save();
            Auth::logoutOtherDevices($request->new);
            Auth::logout();
            flash('Password changed. Please log in again.');
            return redirect('/login');
        }

        return back()->withErrors(['notsame' => 'The new passwords don\'t match.']);
    }

    public function return2FAView()
    {
        $user = auth()->user();

        if($user->totp_status == false){
            $ga = new \PHPGangsta_GoogleAuthenticator();
            $secret = $ga->createSecret();
            $qrcodeurl = "https://chart.googleapis.com/chart?cht=qr&chl=otpauth%3A%2F%2Ftotp%2FDomeinDNS%3Fsecret%3D{$secret}&chs=200x200&chld=L|0";

            $user['totp_token'] = $secret;
            $user->update();
        }else{
            $secret = '';
            $qrcodeurl = '';
        }

        return view('account.2fa', compact('secret', 'qrcodeurl', 'user'));
    }

    public function enable2FA(VerifyTOTP $request)
    {
        $user = auth()->user();

        $ga = new \PHPGangsta_GoogleAuthenticator();
        $checkResult = $ga->verifyCode($user->totp_token, $request->totp, 2);

        if ($checkResult) {
            $user['totp_status'] = true;
            $user->update();

            return redirect('/account/2fa');
        }else{
            return back()->withErrors(['totp' => 'This TOTP code is not correct']);
        }
    }

    public function disable2FA(VerifyTOTP $request)
    {
        $user = auth()->user();

        $ga = new \PHPGangsta_GoogleAuthenticator();
        $checkResult = $ga->verifyCode($user->totp_token, $request->totp, 2);

        if ($checkResult) {
            $user['totp_status'] = false;
            $user->update();

            return redirect('/account/2fa');
        }else{
            return back()->withErrors(['totp' => 'This TOTP code is not correct']);
        }
    }

    public function index()
    {
        $user = auth()->user();

        return view('account.settings', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $attributes['allow_totp_recovery'] = $request->has('allow_totp_recovery');
        $attributes['allow_support'] = $request->has('allow_support');
        $attributes['receive_notifications'] = $request->has('receive_notifications');
        $attributes['dangerzone'] = $request->has('dangerzone');
        $attributes['allow_transfers'] = $request->has('allow_transfers');

        $user->update($attributes);

        flash('Your account settings have been updated.');

        return redirect('/account/settings');
    }

    public function requestResellerpage()
    {
        $user = auth()->user();

        $authorized = $this->checkAuthReseller($user);

        return view('reseller.request', [
            'authorized' => $authorized
        ]);
    }

    public function requestReseller(RequestReseller $request)
    {
        $user = auth()->user();

        $authorized = $this->checkAuthReseller($user);

        if($authorized == false){
            abort(404);
        }

        if($user->reseller == true){
            abort(404);
        }

        $attribute['user_id'] = $user->id;
        $attribute['reason'] = $request->get('reason');

        ResellerRequest::create($attribute);

        return redirect('/reseller/request');
    }

    public function checkAuthReseller($user)
    {
        if($user->reseller == true){
            abort(404);
        }

        $requests = $user->reseller_requests;

        $authorized = true;

        foreach ($requests as $request){
            if($request->handled == false){
                $authorized = false;
            }
        }

        return $authorized;
    }
}
