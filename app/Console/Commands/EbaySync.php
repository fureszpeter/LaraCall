<?php

namespace LaraCall\Console\Commands;

use DateTime as DateTimeOriginal;
use DTS\eBaySDK\Trading\Services\TradingService;
use DTS\eBaySDK\Trading\Types\CustomSecurityHeaderType;
use DTS\eBaySDK\Trading\Types\GetOrdersRequestType;
use DTS\eBaySDK\Trading\Types\GetSellerTransactionsRequestType;
use Illuminate\Console\Command;
use LaraCall\Domain\Services\SyncService;
use LaraCall\Domain\ValueObjects\eBay\EbayTime;
use LaraCall\Domain\ValueObjects\PastDateRange;
use RuntimeException;

class EbaySync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ebay:fetch {--F|from-date=default} {--T|to-date=default} {--I|item=default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Ebay transactions';

    /**
     * @var SyncService
     */
    private $syncService;

    /**
     * @var CustomSecurityHeaderType
     */
    private $customSecurityHeaderType;

    /**
     * @var TradingService
     */
    private $tradingService;

    /**
     * Create a new command instance.
     *
     * @param SyncService              $syncService
     * @param TradingService           $tradingService
     * @param CustomSecurityHeaderType $customSecurityHeaderType
     */
    public function __construct(
        SyncService $syncService,
        TradingService $tradingService,
        CustomSecurityHeaderType $customSecurityHeaderType
    ) {
        parent::__construct();

        $this->syncService              = $syncService;
        $this->customSecurityHeaderType = $customSecurityHeaderType;
        $this->tradingService           = $tradingService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $lastSyncDate = $this->syncService->getLastSyncDate();
        if ( ! $this->isFromDateProvided() && ! $lastSyncDate) {
            $fromDate = (new EbayTime())->setTime(0, 0, 0);
        } elseif ( ! $this->isFromDateProvided() && $lastSyncDate) {
            $fromDate = $lastSyncDate;
        } else {
            $fromDate = new EbayTime($this->option('from-date'));
        }

        $toDate = $this->isToDateProvided()
            ? new EbayTime($this->option('to-date'))
            : new EbayTime();

        $dateRange = new PastDateRange($fromDate, $toDate);

        $this->info('from-date: ' . $dateRange->getDateFrom());
        $this->info('to-date: ' . $dateRange->getDateTo());

        $request                       = new GetOrdersRequestType();
        $request->RequesterCredentials = $this->customSecurityHeaderType;
        $request->ModTimeFrom          = new DateTimeOriginal($dateRange->getDateFrom());
        $request->ModTimeTo            = new DateTimeOriginal($dateRange->getDateTo());

        $response = $this->tradingService->getOrders($request);

        if ($response->Errors) {
            foreach ($response->Errors as $error) {
                $this->error($error->LongMessage);
                throw new RuntimeException($error->LongMessage);
            }
        }

        foreach ($response->OrderArray->Order as $order)
        {
            $this->info('order id: ' . $order->OrderID);
            $this->info('amount payed:' . $order->AmountPaid->value);
            $this->info('amount payed:' . $order->PaidTime->format(DATE_ISO8601));
        }
        dd($response);

    }

    /**
     * @return bool
     */
    private function isFromDateProvided()
    {
        return $this->option('from-date') != 'default';
    }

    /**
     * @return bool
     */
    private function isToDateProvided()
    {
        return $this->option('to-date') != 'default';
    }

}
