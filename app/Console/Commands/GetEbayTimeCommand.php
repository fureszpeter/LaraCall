<?php

namespace LaraCall\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use LaraCall\Domain\Services\EbayService;

/**
 * Class GetItemTransactionsCommand.
 *
 * @package LaraCall
 *
 * @license Proprietary
 */
class GetEbayTimeCommand extends Command
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
    protected $description = 'Get eBay official time.';

    /**
     * @var EbayService
     */
    private $ebayService;

    /**
     * Create a new command instance.
     *
     * @param EbayService    $ebayService
     */
    public function __construct(EbayService $ebayService)
    {
        parent::__construct();
        $this->ebayService = $ebayService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dateTime = $this->ebayService->getOfficialTime();

        $this->info('Local computer time: ' . Carbon::now()->format(DATE_ISO8601));
        $this->info($dateTime->format(DATE_ISO8601));
    }
}
