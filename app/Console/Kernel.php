<?php

namespace LaraCall\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use LaraCall\Console\Commands\GetEbayTimeCommand;
use LaraCall\Console\Commands\GetItemTransactionsCommand;
use LaraCall\Console\Commands\ImportUsers;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
        ImportUsers::class,
        GetItemTransactionsCommand::class,
        GetEbayTimeCommand::class,
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
