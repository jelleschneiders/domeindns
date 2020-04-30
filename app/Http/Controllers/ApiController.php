<?php

namespace App\Http\Controllers;

use App\Http\Requests\VerifyPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'two_factor']);
    }

    public function update(VerifyPassword $request){
        $user = auth()->user();

        if (!Hash::check($request->current, $user->password)) {
            return back()->withErrors(['current' => 'The current password is incorrect.']);
        }

        $token = Str::random(60);

        $arguments['api_token'] = hash('sha256', $token);

        auth()->user()->update($arguments);

        flash('This is the only time you can see your API key. Save this key at a secure place.<hr>'.$token);
        return redirect('/account/api-key');
    }
}
