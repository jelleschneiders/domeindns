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

class DeleteDNSSEC implements ShouldQueue
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
        $req = $client->request('DELETE', '/api/v1/servers/localhost/zones/'.$this->zone->domain.'/cryptokeys/'.$this->zone->dns_sec->pdns_id.'', [
            'headers' => [
                'X-API-Key' => config('domeindns.powerdns.api_key'),
            ]
        ]);

        $code = $req->getStatusCode();

        if($code != 204){
            throw new \Exception('Could not delete dnssec key.');
        }

        $this->zone->dns_sec->delete();

        $this->zone['status'] = Status::$OK;
        $this->zone['dnssec'] = false;
        $this->zone->update();

        Notification::send($this->zone->user_id, 'danger', 'unlock-alt', 'DNSSEC has been disabled for domain '.$this->zone->domain);
    }

    public function failed()
    {
        $zone = Zone::find($this->zone->id);
        $zone->status = Status::$OK;
        $zone->failed_reason = 'dnssec_deletion';
        $zone->save();
    }
}
