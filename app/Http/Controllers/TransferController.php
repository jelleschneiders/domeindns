<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewTransfer;
use App\Http\Requests\UpdateTransfer;
use App\Notification;
use App\Status;
use App\Transfer;
use App\User;
use App\Zone;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'two_factor']);
    }

    public function index()
    {
        $transfers = auth()->user()->transfers;
        $incoming_transfers = Transfer::where('to', auth()->user()->id)->get();
        $incoming_transfers_c = Transfer::where([
            ['to', auth()->user()->id],
            ['status', Status::$TRANSFER_PENDING]
            ])->count();

        return view('domains.transfer.index', compact('transfers', 'incoming_transfers', 'incoming_transfers_c'));
    }

    public function storeView()
    {
        $domains = auth()->user()->zones->sortBy('domain');

        return view('domains.transfer.new', compact('domains'));
    }

    public function store(NewTransfer $request)
    {
        $newuserq = User::where('email', $request->email);
        $newuserc = $newuserq->count();
        $newuser = $newuserq->first();

        $zone = Zone::where([
            ['id', '=', $request->domain],
            ['user_id', '=', auth()->user()->id]
        ])->firstOrFail();

        $transfer = Transfer::where([
            ['zone_id', $zone->id],
            ['status', Status::$TRANSFER_PENDING]
        ])->count();

        if($newuserc != 1){
            return back()->withErrors(['email' => 'Can\'t find a user with this email address.']);
        }

        if(! $newuser->allow_transfers){
            return back()->withErrors(['email' => 'Can\'t transfer a domain to this user.']);
        }

        if($request->email === auth()->user()->email){
            return back()->withErrors(['email' => 'Can\'t transfer a domain to yourself.']);
        }

        if($transfer != 0){
            return back()->withErrors(['domain' => 'There is already a transfer pending for this domain.']);
        }

        $attributes['to'] = $newuser->id;
        $attributes['zone_id'] = $zone->id;

        auth()->user()->transfers()->create($attributes);

        Notification::send($newuser->id, 'info', 'people-carry', auth()->user()->email.' wants to transfer domain '.$zone->domain.' to your account. You can accept or reject this on the domain transfers page.');
        Notification::send(auth()->user()->id, 'info', 'people-carry', 'Transfer of domain '.$zone->domain.' has been initiated.');

        flash('Transfer of domain '.$zone->domain.' has been initiated.');

        return redirect('/domains/transfer');
    }

    public function update(UpdateTransfer $request)
    {
        $transfer = Transfer::where([
            ['id', $request->id],
            ['status', Status::$TRANSFER_PENDING]
        ])->firstOrFail();

        if($request->status == 'accept'){
            if($transfer->to != auth()->user()->id){
                abort(404);
            }

            $transfer->status = Status::$TRANSFER_ACCEPTED;
            $transfer->save();

            $transfer->domain->user_id = $transfer->to;
            $transfer->domain->save();

            if($transfer->domain->tags->count() != 0){
                foreach ($transfer->domain->tags as $tag){
                    $tag->delete();
                }
            }

            Notification::send($transfer->user_id, 'success', 'people-carry', 'Domain '.$transfer->domain->domain.' has been transferred out of your account.');

            flash('Transfer of domain '.$transfer->domain->domain.' has been approved.');
            return redirect('/domains/transfer');
        }

        if(! in_array(auth()->user()->id, [$transfer->to, $transfer->user_id])) {
            abort(404);
        }

        $transfer->status = Status::$TRANSFER_REJECTED;
        $transfer->save();

        Notification::send($transfer->user_id, 'warning', 'people-carry', 'Transfer of domain '.$transfer->domain->domain.' has been rejected.');

        flash('Transfer of domain '.$transfer->domain->domain.' has been rejected.');
        return redirect('/domains/transfer');
    }
}
