<?php

namespace App\Http\Controllers;

use App\Jobs\CreateRecord;
use App\Jobs\DeleteRecord;
use App\Record;
use App\Status;
use App\Zone;
use Illuminate\Http\Request;

class RecordRetryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'two_factor']);
    }

    public function show(string $domain, string $record)
    {
        $zone = $this->check_domain_owner($domain);

        $record = $zone->records()->where([
            ['id', $record],
            ['status', Status::$FAILED]
        ])->firstOrFail();

        return view('records.retry', compact('zone', 'record'));
    }

    public function update(string $domain, string $record)
    {
        $zone = $this->check_domain_owner($domain);

        $record = $zone->records()->where([
            ['id', $record],
            ['status', Status::$FAILED]
        ])->firstOrFail();

        if($record->failed_reason == 'creation'){
            $record['status'] = Status::$PENDING_CREATION;
            $record->update();
            CreateRecord::dispatch($record);
        }

        if($record->failed_reason == 'deletion'){
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
