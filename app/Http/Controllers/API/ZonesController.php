<?php

namespace App\Http\Controllers\API;

use App\Jobs\CreateZone;
use App\Jobs\DeleteZone;
use App\Status;
use App\User;
use App\Zone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class ZonesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $user = $this->authorizedUser($request->reseller_user);

        $getfields = $user->zones()->select('id', 'domain', 'dnssec', 'status', 'created_at', 'updated_at')->get();

        return response()->json([
            'success' => true,
            'data' => $getfields]);
    }

    public function show(Request $request)
    {
        $user = $this->authorizedUser($request->reseller_user);

        $zone = Zone::where([
            ['id', '=', $request->id],
            ['user_id', '=', $user->id]
        ])->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $zone->id,
                'domain' => $zone->domain,
                'dnssec' => $zone->dnssec,
                'status' => $zone->status,
                'created_at' => $zone->created_at,
                'updated_at' => $zone->updated_at
            ]]);
    }

    public function store(\App\Http\Requests\API\CreateZone $request)
    {
        $user = $this->authorizedUser($request->reseller_user);

        $attribute['domain'] = $request->get('domain');

        $zone = $user->zones()->create($attribute);

        if($request->get('default_nameservers')){
            $zone->insertDefaultRecords();
        }

        CreateZone::dispatch($zone);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $zone->id,
                'domain' => $zone->domain,
                'dnssec' => $zone->dnssec,
                'status' => $zone->status,
                'created_at' => $zone->created_at,
                'updated_at' => $zone->updated_at
            ]]);
    }

    public function destroy(Request $request)
    {
        $user = $this->authorizedUser($request->reseller_user);

        $zone = Zone::where([
            ['id', '=', $request->id],
            ['user_id', '=', $user->id],
            ['status', '=', Status::$OK]
        ])->firstOrFail();

        $zone['status'] = Status::$PENDING_DELETION;
        $zone->update();

        DeleteZone::dispatch($zone);

        return response()->json([
            'success' => true,
        ]);
    }

    public function showDNSSEC(Request $request)
    {
        $user = $this->authorizedUser($request->reseller_user);

        $zone = Zone::where([
            ['id', '=', $request->id],
            ['user_id', '=', $user->id],
            ['status', '=', Status::$OK]
        ])->firstOrFail();

        if($zone->dnssec == true) {
            $pubkeysplit = explode(" ", $zone->dns_sec->dnskey);
            $dssplit = explode(" ", $zone->dns_sec->ds2);

            $getfields['ds_record'] = $zone->dns_sec->ds2;
            $getfields['digest'] = $dssplit[3];
            $getfields['digest_type'] = "SHA256";
            $getfields['algorithm'] = $pubkeysplit[2];
            $getfields['public_key'] = $pubkeysplit[3];
            $getfields['key_tag'] = $dssplit[0];
            $getfields['flags'] = $zone->dns_sec->flags;

        }else{
            $getfields = null;
        }

        return response()->json([
            'success' => $zone->dnssec,
            'data' => $getfields]);
    }

    public function authorizedUser($reseller_user)
    {
        $user = auth()->user();
        if(isset($reseller_user)){
            $user = User::where([
                ['id', $reseller_user],
                ['managed_by', auth()->user()->id]
            ])->firstOrFail();
        }

        return $user;
    }
}
