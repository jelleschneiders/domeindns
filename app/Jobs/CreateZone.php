<?php

namespace App\Jobs;

use App\Nameserver;
use App\Notification;
use App\Status;
use App\Zone;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateZone implements ShouldQueue
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
        if(in_array($this->zone->domain, config('domeindns.forbidden_domains'))){
            $zone = Zone::find($this->zone->id);
            $zone->delete();
            Notification::send($this->zone->user_id, 'danger', 'meh-rolling-eyes', 'The creation of domain '.$this->zone->domain.' is forbidden. We have deleted this domain out of your domain list.');
        }else{
            $nameservers = $this->zone->user->nameservers()->orderByDesc('ipv4')->get();

            if($nameservers->count() == 0){
                $nameservers = Nameserver::where('default', true)->orderByDesc('ipv4')->get();
            }

            foreach ($nameservers as $nameserver){
                $nameserverx[] = $nameserver->nameserver.'.';
            }

            $client = new Client(['base_uri' => config('domeindns.powerdns.host')]);
            $req = $client->request('POST', '/api/v1/servers/localhost/zones', [
                'timeout' => 5,
                'connect_timeout' => 5,
                'headers' => [
                    'X-API-Key' => config('domeindns.powerdns.api_key'),
                ],
                'json' => [
                    'name' => ''.$this->zone->domain.'.',
                    'kind' => 'Native',
                    'masters' => [],
                    'api_rectify' => true,
                    'nameservers' => $nameserverx
                ]
            ]);
            $code = $req->getStatusCode();

            if($code == 201){
                $zone = Zone::find($this->zone->id);
                $zone->status = Status::$OK;
                $zone->save();
            }

            Notification::send($this->zone->user_id, 'info', 'check', 'Domain '.$this->zone->domain.' has been created');
        }
    }

    public function failed()
    {
        $zone = Zone::find($this->zone->id);
        $zone->status = Status::$FAILED;
        $zone->failed_reason = 'creation';
        $zone->save();
    }
}
