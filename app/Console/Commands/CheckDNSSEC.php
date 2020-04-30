<?php

namespace App\Console\Commands;

use App\Status;
use App\Zone;
use Illuminate\Console\Command;

class CheckDNSSEC extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:checkdnssec';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if DNSSEC is valid for a domain';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $zones = Zone::where([
            ['status', '=', Status::$OK],
            ['dnssec', true],
        ])->get();

        foreach ($zones as $zone) {
            \App\Jobs\CheckDNSSEC::dispatch($zone);
        }
    }
}
