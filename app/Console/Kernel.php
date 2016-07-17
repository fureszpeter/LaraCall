<?php

namespace LaraCall\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use LaraCall\Console\Commands\EbayTimeCommand;
use LaraCall\Console\Commands\GetItemTransactionsCommand;
use LaraCall\Console\Commands\GetSellerTransactions;
use LaraCall\Console\Commands\ImportUsers;
use LaraCall\Console\Commands\ParseTransactions;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ImportUsers::class,
        GetItemTransactionsCommand::class,
        EbayTimeCommand::class,
        GetSellerTransactions::class,
        ParseTransactions::class,
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
