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

class DeleteRecord implements ShouldQueue
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

        $client = new Client(['base_uri' => config('domeindns.powerdns.host')]);
        $req = $client->request('PATCH', '/api/v1/servers/localhost/zones/'.$this->record->zone->domain.'', [
            'headers' => [
                'X-API-Key' => config('domeindns.powerdns.api_key'),
            ],
            'json' => [
                'rrsets' => [
                    0 => [
                        'name' => $recordname,
                        'type' => $this->record->record_type,
                        'changetype' => 'DELETE',
                        'records' => [],
                    ],
                ],
            ]
        ]);
        $code = $req->getStatusCode();

        if($code == 204){
            $record = Record::find($this->record->id);
            $record->delete();
        }
    }

    public function failed()
    {
        $record = Record::find($this->record->id);
        $record->status = Status::$FAILED;
        $record->failed_reason = 'deletion';
        $record->save();
    }
}
