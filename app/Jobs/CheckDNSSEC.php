<?php

namespace App\Jobs;

use App\Notification;
use App\Zone;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CheckDNSSEC implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;

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
        $error = false;
        $dsrecordlocal = $this->zone->dns_sec->ds2;

        $request = new \Net_DNS2_Resolver(['nameservers' => ['8.8.8.8', '8.8.4.4']]);

        try {
            $result = $request->query($this->zone->domain, 'DS');
        } catch(Net_DNS2_Exception $e) {
            echo "::query() failed: ", $e->getMessage(), "\n";
        }

        if(empty($result->answer)){
            $error = true;
        }

        foreach($result->answer as $dsrecord)
        {
            $dsrecord = ''.$dsrecord->keytag.' '.$dsrecord->algorithm.' '.$dsrecord->digesttype.' '.$dsrecord->digest.'';

            if($dsrecord != $dsrecordlocal){
                $error = true;
            }
        }

        if($error == true){
            Notification::send($this->zone->user_id, 'danger', 'exclamation', 'DNSSEC for domain '.$this->zone->domain.' is invalid.');
        }
    }
}
