<?php

namespace LaraCall\Console\Commands;

use DateTime;
use Illuminate\Console\Command;
use LaraCall\Domain\Services\SyncService;
use LaraCall\Domain\ValueObjects\DateTime as DateTimeVO;

class EbayLastSyncDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ebay:last-sync-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the last date of sync.';

    /**
     * @var SyncService
     */
    private $service;

    /**
     * Create a new command instance.
     *
     * @param SyncService $service
     */
    public function __construct(SyncService $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	$date = $this->service->getLastSyncDate();
        if ($date instanceof DateTime) {
            $this->output->write(
                sprintf('Last sync date: %s', DateTimeVO::instance($date))
            );

            return;
        }

        $this->warn(sprintf('There is no sync, please do first sync manually.'));

        return;
    }

}
