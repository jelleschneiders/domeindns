<?php

namespace App\Jobs;

use App\Record;
use App\Status;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateRecord implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $record;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Record $record)
    {
        $this->record = $record;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $recordname = $this->record->formatName();

        $contentrecords = Record::where([
            ['name', $this->record->name],
            ['zone_id', $this->record->zone_id],
            ['record_type', $this->record->record_type],
        ])->get();

        $contentdns = [];
        foreach ($contentrecords as $key => $contentrecord) {
            $contentdns[$key] = $contentrecord->formatRecord();
        }

        $client = new Client(['base_uri' => config('domeindns.powerdns.host')]);

        $req = $client->request('PATCH', '/api/v1/servers/localhost/zones/'.$this->record->zone->domain.'', [
            'timeout' => 30,
            'connect_timeout' => 30,
            'headers' => [
                'X-API-Key' => config('domeindns.powerdns.api_key'),
            ],
            'json' => [
                'rrsets' => [
                    0 => [
                        'name' => $recordname,
                        'type' => $this->record->record_type,
                        'ttl' => $this->record->ttl,
                        'changetype' => 'REPLACE',
                        'records' => $contentdns,
                    ],
                ],
            ]
        ]);

        $code = $req->getStatusCode();

        if($code != 204){
            throw new \Exception('Could not create record.');
        }

        $record = Record::find($this->record->id);
        $record->status = Status::$OK;
        $record->save();
    }

    public function failed()
    {
        $record = Record::find($this->record->id);
        $record->status = Status::$FAILED;
        $record->failed_reason = 'creation';
        $record->save();
    }

    /**
     * @return string
     */

}
