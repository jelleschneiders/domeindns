<?php

namespace App\Http\Controllers;

use App\Jobs\CreateZone;
use App\Jobs\DeleteZone;
use App\Status;
use App\Zone;
use Illuminate\Http\Request;

class ZoneRetryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'two_factor']);
    }

    public function show(string $domain)
    {
        $zone = $this->check_domain_owner($domain);

        return view('domains.retry', compact('zone'));
    }

    public function update(string $domain)
    {
        $zone = $this->check_domain_owner($domain);

        if($zone->failed_reason == 'creation'){
            $zone['status'] = Status::$PENDING_CREATION;
            $zone->update();
            CreateZone::dispatch($zone);
        }

        if($zone->failed_reason == 'deletion'){
            $zone['status'] = Status::$PENDING_DELETION;
            $zone->update();
            DeleteZone::dispatch($zone);
        }

        return redirect('/domains');
    }

    public function check_domain_owner(string $domain)
    {
        $zone = Zone::where([
            ['user_id', '=', auth()->user()->id],
            ['domain', '=', $domain],
            ['status', '=', Status::$FAILED]
        ])->firstOrFail();

        return $zone;
    }
}
