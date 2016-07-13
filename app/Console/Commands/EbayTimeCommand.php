<?php

namespace LaraCall\Console\Commands;

use Illuminate\Console\Command;
use LaraCall\Domain\Services\EbayService;

class EbayTimeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ebay:time';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var EbayService
     */
    private $service;

    /**
     * Create a new command instance.
     *
     * @param EbayService $service
     */
    public function __construct(EbayService $service)
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
        $this->info('Timezone: ' . $this->service->getOfficialTime()->getTimezone());
        $this->info('Time:' . $this->service->getOfficialTime()->format(DATE_ISO8601));
    }
}
