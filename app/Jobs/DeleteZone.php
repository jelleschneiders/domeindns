<?php

namespace App\Jobs;

use App\Notification;
use App\Status;
use App\Zone;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DeleteZone implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $zone;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Zone $zone)
    {
        $this->zone = $zone;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client(['base_uri' => config('domeindns.powerdns.host')]);
        $req = $client->request('DELETE', '/api/v1/servers/localhost/zones/'.$this->zone->domain.'', [
            'headers' => [
                'X-API-Key' => config('domeindns.powerdns.api_key')
            ]
        ]);
        $code = $req->getStatusCode();

        if($code == 204){
            $zone = Zone::find($this->zone->id);

            if($zone->tags->count() != 0){
                foreach ($zone->tags as $tag){
                    $tag->delete();
                }
            }

            $zone->delete();

            Notification::send($this->zone->user_id, 'danger', 'trash-alt', 'Domain '.$this->zone->domain.' has been deleted');
        }
    }

    public function failed()
    {
        $zone = Zone::find($this->zone->id);
        $zone->status = Status::$FAILED;
        $zone->failed_reason = 'deletion';
        $zone->save();
    }
}
