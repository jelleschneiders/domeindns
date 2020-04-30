<?php

namespace App\Jobs;

use App\Notification;
use App\Zone;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CheckNSRecords implements ShouldQueue
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
        $currentdomainrecords = dns_get_record($this->zone->domain, DNS_NS);

        $counttotal = 0;

        foreach ($currentdomainrecords as $currentdomainrecord){
            $countrecord = $this->zone->records()->where([
                ['record_type', 'NS'],
                ['name', NULL],
                ['content', $currentdomainrecord['target'].'.']
            ])->orWhere([
                ['record_type', 'NS'],
                ['name', ''],
                ['content', $currentdomainrecord['target'].'.']
            ])->count();

            if($countrecord == 0){
                $counttotal = $counttotal - 1;
            }

            $counttotal = $counttotal + $countrecord;
        }

        if($counttotal != $this->zone->records()->where([
                ['record_type', 'NS'],
                ['name', NULL],
            ])->orWhere([
                ['record_type', 'NS'],
                ['name', ''],
            ])->count()){
            Notification::send($this->zone->user_id, 'danger', 'exclamation', 'Nameservers for domain '.$this->zone->domain.' don\'t match with your NS records.');
        }
    }
}
