<?php

namespace LaraCall\Console\Commands;

use DateInterval;
use DateTime as DateTimeOriginal;
use DateTime;
use DTS\eBaySDK\Trading\Services\TradingService;
use DTS\eBaySDK\Trading\Types\CustomSecurityHeaderType;
use DTS\eBaySDK\Trading\Types\GetOrdersRequestType;
use Illuminate\Console\Command;
use LaraCall\Domain\Services\SyncService;
use LaraCall\Domain\ValueObjects\DateSplitter;
use LaraCall\Domain\ValueObjects\eBay\CheckoutStatusVO;
use LaraCall\Domain\ValueObjects\eBay\EbayTime;
use LaraCall\Domain\ValueObjects\eBay\GetOrdersResultVO;
use LaraCall\Domain\ValueObjects\eBay\OrderLineItemId;
use LaraCall\Domain\ValueObjects\eBay\PaymentStatusVO;
use LaraCall\Domain\ValueObjects\PastDateRange;
use RuntimeException;
use UnexpectedValueException;

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
        $fromDate          = $this->getFromDate();
        $toDate            = $this->getToDate();
        $providedDateRange = new PastDateRange($fromDate, $toDate);

        $this->info(
            sprintf(
                'Provided date range. From: %s, To: %s',
                $providedDateRange->getDateFrom(),
                $providedDateRange->getDateTo()
            )
        );

        $dateSplitter       = new DateSplitter($providedDateRange);
        $splittedDateRanges = $dateSplitter->split(new DateInterval('P90D'));

        $i = 0;
        foreach ($splittedDateRanges as $splittedDateRange) {
            $this->info('=========');
            $this->info(
                sprintf(
                    '%s range. From: %s, To: %s' . PHP_EOL,
                    ++$i,
                    $splittedDateRange->getDateFrom(),
                    $splittedDateRange->getDateTo()
                )
            );
            $request                       = new GetOrdersRequestType();
            $request->RequesterCredentials = $this->customSecurityHeaderType;
            $request->IncludeFinalValueFee = true;

            $request->CreateTimeFrom = new DateTimeOriginal(
                $providedDateRange->getDateFrom()->format('Y-m-d H:i:s.u'),
                $providedDateRange->getDateFrom()->getTimezone());
            $request->CreateTimeTo   = new DateTimeOriginal(
                $providedDateRange->getDateTo()->format('Y-m-d H:i:s.u'),
                $providedDateRange->getDateTo()->getTimezone());

            $response = $this->tradingService->getOrders($request);
            if ($response->Errors) {
                foreach ($response->Errors as $error) {
                    $this->error($error->LongMessage);
                    throw new RuntimeException($error->LongMessage);
                }
            }
            $orderResult = [];
            foreach ($response->OrderArray->Order as $order) {
                $orderResult[] = new GetOrdersResultVO(
                    new OrderLineItemId($order->OrderID),
                    new CheckoutStatusVO($order->CheckoutStatus->Status),
                    new PaymentStatusVO($order->CheckoutStatus->eBayPaymentStatus),
                    floatval($order->AmountPaid->value),
                    $order->TransactionArray,
                    $order->PaidTime
                );
            }

            echo json_encode($orderResult, JSON_PRETTY_PRINT);

        }

        return;

    }

    /**
     * @return EbayTime
     *
     * @throws UnexpectedValueException If date is more than 90 days back.
     */
    public function getFromDate()
    {
        if ($this->isFromDateProvided()) {
            $date = new EbayTime($this->option('from-date'));
        } else {
            $lastSyncDate = $this->syncService->getLastSyncDate();
            $date         = $lastSyncDate ?: (new EbayTime())->setTime(0, 0, 0);
        }

        if ($date->diff(new DateTime())->days > 90) {
            throw new UnexpectedValueException('From date cannot be set back more than 90 days in the past.');
        }

        return $date;
    }

    /**
     * @return bool
     */
    private function isFromDateProvided()
    {
        return $this->option('from-date') != 'default';
    }

    /**
     * @return EbayTime
     */
    public function getToDate()
    {
        $toDate = $this->isToDateProvided()
            ? new EbayTime($this->option('to-date'))
            : new EbayTime('now - 2 minutes');

        return $toDate;
    }

    /**
     * @return bool
     */
    private function isToDateProvided()
    {
        return $this->option('to-date') != 'default';
    }
}
