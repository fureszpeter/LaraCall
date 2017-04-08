<?php

namespace LaraCall\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use LaraCall\Console\Commands\ApiGetPayment;
use LaraCall\Console\Commands\ApiSubscriptionCreate;
use LaraCall\Console\Commands\ApiSubscriptionGet;
use LaraCall\Console\Commands\BlockUserCommand;
use LaraCall\Console\Commands\EbayChangeListingQuantityCommand;
use LaraCall\Console\Commands\EbayGetBestOffersCommand;
use LaraCall\Console\Commands\EbayGetItemsCommand;
use LaraCall\Console\Commands\EbayGetMyInfoCommand;
use LaraCall\Console\Commands\EbayGetNeedFeedbackTransactions;
use LaraCall\Console\Commands\EbayGetSellerTransactionsCommand;
use LaraCall\Console\Commands\EbayGetTransactionCommand;
use LaraCall\Console\Commands\EbayGetUserCommand;
use LaraCall\Console\Commands\EbayMarkShippedCommand;
use LaraCall\Console\Commands\GenerateDeliveryTokenCommand;
use LaraCall\Console\Commands\ImportPayPalIpnCommand;
use LaraCall\Console\Commands\ImportSubscriptionsCommand;
use LaraCall\Console\Commands\ImportUsersCommand;
use LaraCall\Console\Commands\IpnProcessCommand;
use LaraCall\Console\Commands\IpnListCommand;
use LaraCall\Console\Commands\MigrateDbCommand;
use LaraCall\Console\Commands\testCommand;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        IpnListCommand::class,
        IpnProcessCommand::class,
        MigrateDbCommand::class,
        ImportUsersCommand::class,
        ImportSubscriptionsCommand::class,
        ImportPayPalIpnCommand::class,
        GenerateDeliveryTokenCommand::class,

        /*
         * Ebay commands
         */
        EbayGetUserCommand::class,
        EbayGetTransactionCommand::class,
        EbayGetMyInfoCommand::class,
        EbayGetItemsCommand::class,
        EbayGetSellerTransactionsCommand::class,
        EbayMarkShippedCommand::class,
        EbayGetBestOffersCommand::class,
        EbayGetNeedFeedbackTransactions::class,
        EbayChangeListingQuantityCommand::class,

        /*
         * API commands
         */
        ApiSubscriptionGet::class,
        ApiSubscriptionCreate::class,
        ApiGetPayment::class,

        /*
         * Maintenance commands
         */
        BlockUserCommand::class,

        /*
         *
         */
        testCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }
}
