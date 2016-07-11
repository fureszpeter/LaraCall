<?php

namespace LaraCall\Console\Commands;

use DTS\eBaySDK\Trading\Services\TradingService;
use Illuminate\Console\Command;
use LaraCall\Domain\Services\EbayService;

/**
 * Class GetItemTransactionsCommand.
 *
 * @package LaraCall
 *
 * @license Proprietary
 */
class GetItemTransactionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ebay:transactions:item';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get eBay transactions for item.';

    /**
     * @var TradingService
     */
    private $tradingService;

    /**
     * @var EbayService
     */
    private $ebayService;

    /**
     * Create a new command instance.
     *
     * @param TradingService $tradingService
     * @param EbayService    $ebayService
     */
    public function __construct(TradingService $tradingService, EbayService $ebayService)
    {
        parent::__construct();
        $this->tradingService = $tradingService;
        $this->ebayService = $ebayService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $transactions = $this->ebayService->getItemTransactions('110181384286');

        dd($transactions);
    }
}
