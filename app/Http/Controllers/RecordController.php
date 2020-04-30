<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePreset;
use App\Http\Requests\CreateRecord;
use App\Http\Requests\EditRecord;
use App\Jobs\CheckNSRecords;
use App\Jobs\DeleteRecord;
use App\Record;
use App\Status;
use App\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class RecordController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'two_factor']);
    }

    public function index(Request $request){
        $zone = $this->check_domain_owner($request->domain);

        $records = $zone->records->sortBy('record_type');

        return view('records.list', compact('zone', 'records'));
    }

    public function show(string $domain, string $record){
        $zone = $this->check_domain_owner($domain);

        $record = $zone->records()->where([
            ['id', $record],
            ['status', Status::$OK]
        ])->firstOrFail();

        return view('records.edit', compact('zone', 'record'));

    }

    public function update(EditRecord $request){
        $zone = $this->check_domain_owner($request->domain);

        $record = $zone->records()->where([
            ['id', $request->record],
            ['status', Status::$OK]
        ])->firstOrFail();

        $record['status'] = Status::$PENDING_UPDATE_DELETION;
        $record->update();

        DeleteRecord::dispatch($record);

        Record::create_new($zone->id, $request->get('type'), $request->get('ttl'), $request->get('name'), $request->get('content'));

        return redirect('/domain/'.$zone->domain.'/records');
    }

    public function returnCreatePage(Request $request){
        $zone = $this->check_domain_owner($request->domain);

        return view('records.create', compact('zone'));
    }

    public function store(CreateRecord $request){
        $zone = $this->check_domain_owner($request->domain);

        Record::create_new($zone->id, $request->get('type'), $request->get('ttl'), $request->get('name'), $request->get('content'));

        return redirect('/domain/'.$zone->domain.'/records');
    }

    public function destroy(string $domain, string $record){
        $zone = $this->check_domain_owner($domain);

        $record = $zone->records()->where('id', $record)->firstOrFail();
        $record['status'] = Status::$PENDING_DELETION;
        $record->update();

        $contentrecords = Record::where([
            ['name', $record->name],
            ['zone_id', $record->zone_id],
            ['record_type', $record->record_type],
            ['status', '=', Status::$OK]
        ])->get();

        DeleteRecord::dispatch($record);

        if($contentrecords->count() != 0) {
            foreach ($contentrecords as $contentrecord) {
                \App\Jobs\CreateRecord::dispatch($contentrecord);
            }
        }

        return redirect('/domain/'.$zone->domain.'/records');
    }

    public function returnPresetPage(Request $request){
        $zone = $this->check_domain_owner($request->domain);

        return view('records.createpreset', compact('zone'));
    }

    public function storePreset(CreatePreset $request)
    {
        $zone = $this->check_domain_owner($request->domain);

        if($request->preset == 'googlemx'){
            $checkrecord1 = $zone->checkExistingRecord('MX', NULL, '1 aspmx.l.google.com.');
            $checkrecord2 = $zone->checkExistingRecord('MX', NULL, '5 alt1.aspmx.l.google.com.');
            $checkrecord3 = $zone->checkExistingRecord('MX', NULL, '5 alt2.aspmx.l.google.com.');
            $checkrecord4 = $zone->checkExistingRecord('MX', NULL, '10 alt3.aspmx.l.google.com.');
            $checkrecord5 = $zone->checkExistingRecord('MX', NULL, '10 alt4.aspmx.l.google.com.');

            if($checkrecord1 == true) { return back()->withErrors('A record within this preset already exists in your zone.'); }
            if($checkrecord2 == true) { return back()->withErrors('A record within this preset already exists in your zone.'); }
            if($checkrecord3 == true) { return back()->withErrors('A record within this preset already exists in your zone.'); }
            if($checkrecord4 == true) { return back()->withErrors('A record within this preset already exists in your zone.'); }
            if($checkrecord5 == true) { return back()->withErrors('A record within this preset already exists in your zone.'); }

            $zone->insertGoogleMXRecords();
        }

        return redirect('/domain/'.$zone->domain.'/records');
    }

    public function check_domain_owner(string $domain)
    {
        $zone = Zone::where([
            ['user_id', '=', auth()->user()->id],
            ['domain', '=', $domain],
            ['status', '=', Status::$OK]
        ])->firstOrFail();

        return $zone;
    }
}
