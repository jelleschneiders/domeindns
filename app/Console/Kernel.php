<?php

namespace App\Console;

use App\Console\Commands\CheckDNSSEC;
use App\Console\Commands\CheckNSRecords;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CheckNSRecords::class,
        CheckDNSSEC::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('command:checknsrecords')->weeklyOn(1, '10:00');
        $schedule->command('command:checkdnssec')->dailyAt('11:00');
        $schedule->command('personal-data-export:clean')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
