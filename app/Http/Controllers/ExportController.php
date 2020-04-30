<?php

namespace App\Http\Controllers;

use App\Http\Requests\VerifyPassword;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\PersonalDataExport\Jobs\CreatePersonalDataExportJob;

class ExportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'two_factor']);
    }

    public function index()
    {
        return view('account.export');
    }

    public function create(VerifyPassword $request)
    {
        $user = auth()->user();

        if (!Hash::check($request->current, $user->password)) {
            return back()->withErrors(['current' => 'The current password is incorrect.']);
        }

        $latest = auth()->user()->dataexports()->latest('created_at')->first();

        if(auth()->user()->dataexports()->count() != 0){
            $latesttime = $latest->created_at->addMinutes('10');

            $time = Carbon::now();

            if($latesttime > $time){
                flash('Please wait 10 minutes before requesting a new data export.');
                return redirect('/account/export');
            }
        }

        auth()->user()->dataexports()->create();

        dispatch(new CreatePersonalDataExportJob(auth()->user()));

        flash('We\'re now preparing your data export. You will receive an email shortly with your <strong>personal</strong> download link.');

        return redirect('/account/export');
    }

}
