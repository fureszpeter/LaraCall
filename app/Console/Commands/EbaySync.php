<?php

namespace LaraCall\Console\Commands;

use Carbon\Carbon;
use DateInterval;
use DateTime as DateTimeOriginal;
use DTS\eBaySDK\Trading\Services\TradingService;
use DTS\eBaySDK\Trading\Types\CustomSecurityHeaderType;
use DTS\eBaySDK\Trading\Types\GetOrdersRequestType;
use Illuminate\Console\Command;
use LaraCall\Domain\Services\SyncService;
use LaraCall\Domain\ValueObjects\DateSplitter;
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

			$request->CreateTimeFrom = new DateTimeOriginal($providedDateRange->getDateFrom()->format('Y-m-d H:i:s.u'), $providedDateRange->getDateFrom()->getTimezone());
			$request->CreateTimeTo   = new DateTimeOriginal($providedDateRange->getDateTo()->format('Y-m-d H:i:s.u'), $providedDateRange->getDateTo()->getTimezone());

			$response = $this->tradingService->getOrders($request);
			if ($response->Errors) {
				foreach ($response->Errors as $error) {
					$this->error($error->LongMessage);
					throw new RuntimeException($error->LongMessage);
				}
			}
			foreach ($response->OrderArray->Order as $order) {
				$this->info(sprintf('order id: %s', $order->OrderID));
				$this->info(sprintf('amount payed: %s', $order->AmountPaid->value));
				$this->info(sprintf('Buyer id: %s', $order->BuyerUserID));
				$this->info(sprintf('Checkout status: %s', $order->CheckoutStatus->Status));
				$this->info(sprintf('Ebay payment status: %s', $order->CheckoutStatus->eBayPaymentStatus));
				//var_dump($order->TransactionArray->Transaction);

				$this->info(
					sprintf(
						'payment date: %s',
						$order->PaidTime instanceof \DateTime
							? $order->PaidTime->format(DATE_ISO8601)
							: 'never paid'
					)
				);
			}

		}

		return;

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

	/**
	 * @return EbayTime
	 */
	public function getFromDate()
	{
		if ($this->isFromDateProvided()) {
			return new EbayTime($this->option('from-date'));
		}

		$lastSyncDate = $this->syncService->getLastSyncDate();

		return $lastSyncDate ?: (new EbayTime())->setTime(0, 0, 0);
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
}
