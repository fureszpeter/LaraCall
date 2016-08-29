<?php

namespace LaraCall\Console\Commands;

use DTS\eBaySDK\Trading\Services\TradingService;
use DTS\eBaySDK\Trading\Types\GeteBayOfficialTimeRequestType;
use Illuminate\Console\Command;

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
     * @var TradingService
     */
    private $service;

    /**
     * Create a new command instance.
     *
     * @param TradingService $service
     */
    public function __construct(TradingService $service)
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
    	$response = $this->service->geteBayOfficialTime(new GeteBayOfficialTimeRequestType());
	    $timestamp = $response->Timestamp;

        $this->info('Timezone: ' . $timestamp->getTimezone()->getName());
        $this->info('Time:' . $timestamp->format(DATE_ISO8601));
    }
}
