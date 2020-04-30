<?php

namespace App\Console\Commands;

use App\Status;
use App\Zone;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckNSRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:checknsrecords';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all active zones, and check if the nameservers are setup correctly.';

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
        $time2days = Carbon::now()->subDays(2);

        $zones = Zone::where([
            ['status', '=', Status::$OK],
        ])->whereDate('created_at', '<', $time2days)->get();

        foreach ($zones as $zone) {
            \App\Jobs\CheckNSRecords::dispatch($zone);
        }
    }
}
