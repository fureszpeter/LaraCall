<?php

namespace LaraCall\Console\Commands;

use Illuminate\Console\Command;
use LaraCall\Domain\Services\SyncService;
use LaraCall\Domain\ValueObjects\DateTime;
use ValueObjects\DateTime\Date;

class EbaySync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ebay:fetch {--F|from-date=} {--T|to-date=} {--I|item=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Ebay transactions';

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
        $dateFrom = $this->option('from-date')
            ? DateTime::createFromFormat()
            : new Date();

        $this->info($dateFrom);

        return;
    }

}
