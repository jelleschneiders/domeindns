<?php

namespace App\Jobs;

use App\DNSSEC;
use App\Notification;
use App\Status;
use App\Zone;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateDNSSEC implements ShouldQueue
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
        $req = $client->request('POST', '/api/v1/servers/localhost/zones/'.$this->zone->domain.'/cryptokeys', [
            'headers' => [
                'X-API-Key' => config('domeindns.powerdns.api_key'),
            ],
            'json' => [
                'keytype' => 'csk',
                'active' => true,
            ]
        ]);

        $code = $req->getStatusCode();

        if($code != 201){
            throw new \Exception('Could not create dnssec key.');
        }

        $content = (string) $req->getBody();
        $content = json_decode($content, true);

        $attribute['zone_id'] = $this->zone->id;
        $attribute['algorithm'] = $content['algorithm'];
        $attribute['bits'] = $content['bits'];
        $attribute['dnskey'] = $content['dnskey'];
        $attribute['ds1'] = $content['ds'][0];
        $attribute['ds2'] = $content['ds'][1];
        $attribute['ds3'] = $content['ds'][2];
        $attribute['flags'] = $content['flags'];
        $attribute['pdns_id'] = $content['id'];
        $attribute['keytype'] = $content['keytype'];
        $attribute['privatekey'] = $content['privatekey'];
        $attribute['type'] = $content['type'];

        DNSSEC::create($attribute);

        $this->zone['status'] = Status::$OK;
        $this->zone['dnssec'] = true;
        $this->zone->update();

        Notification::send($this->zone->user_id, 'success', 'shield-alt', 'DNSSEC has been enabled for domain '.$this->zone->domain);
    }

    public function failed()
    {
        $zone = Zone::find($this->zone->id);
        $zone->status = Status::$OK;
        $zone->failed_reason = 'dnssec_creation';
        $zone->save();
    }
}
