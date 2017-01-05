<?php

namespace LaraCall\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use LaraCall\Console\Commands\IpnProcessCommand;
use LaraCall\Console\Commands\ListPayPalIpnMessagesCommand;
use LaraCall\Console\Commands\MigrateDbCommand;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ListPayPalIpnMessagesCommand::class,
        IpnProcessCommand::class,
        MigrateDbCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }
}
