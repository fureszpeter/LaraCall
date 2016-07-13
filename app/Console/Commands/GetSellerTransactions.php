<?php

namespace LaraCall\Console\Commands;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use DTS\eBaySDK\Trading\Services\TradingService;
use Furesz\TypeChecker\TypeChecker;
use Illuminate\Console\Command;
use LaraCall\Domain\Entities\ApiCronLog;
use LaraCall\Domain\Entities\EbayTransactionLog;
use LaraCall\Domain\Services\EbayService;
use LaraCall\Domain\ValueObjects\EbayConfig;
use LaraCall\Domain\ValueObjects\PastDateRange;
use OutOfBoundsException;
use UnexpectedValueException;

/**
 * Class GetItemTransactionsCommand.
 *
 * @package LaraCall
 *
 * @license Proprietary
 */
class GetSellerTransactions extends Command
{
    const API_COMMAND_NAME = 'getSellerTransactions';
    const DATE_FORMAT = 'Y-m-d\TH:i:s';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ebay:transactions:seller 
        {--date-time-from=default : The start date of the period. (format: '.self::DATE_FORMAT.'}
        {--date-time-to=default : The end date of the period. (format: Y-m-d H:i:s}. Default is now.
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get eBay transactions for a seller.';

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    protected $cronRepository;

    /**
     * @var TradingService
     */
    private $tradingService;

    /**
     * @var EbayService
     */
    private $ebayService;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var EbayConfig
     */
    private $ebayConfig;

    /**
     * Create a new command instance.
     *
     * @param TradingService         $tradingService
     * @param EbayService            $ebayService
     * @param EntityManagerInterface $em
     * @param EbayConfig             $ebayConfig
     */
    public function __construct(
        TradingService $tradingService,
        EbayService $ebayService,
        EntityManagerInterface $em,
        EbayConfig $ebayConfig
    ) {
        parent::__construct();

        $this->tradingService = $tradingService;
        $this->ebayService = $ebayService;
        $this->em = $em;
        $this->cronRepository = $this->em->getRepository(ApiCronLog::class);
        $this->ebayConfig = $ebayConfig;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dateTimeFrom = $this->getDateTimeFrom();
        $dateTimeTo = $this->getDateTimeTo();

        $dateRange = new PastDateRange($dateTimeFrom, $dateTimeTo);

        $transactions = $this->ebayService->getSellerTransactions($dateRange);

        $cronLogEntity = new ApiCronLog($dateRange, self::API_COMMAND_NAME);
        $this->em->persist($cronLogEntity);

        $transactionTypes = $transactions->Transaction;
        $transactionLogs = [];
        foreach ($transactionTypes as $transactionType) {
            $transactionLog = new EbayTransactionLog(
                $transactionType->OrderLineItemID,
                $this->ebayConfig->getSellerUserName(),
                $transactionType->CreatedDate,
                json_encode($transactionType->toArray())
            );
            $transactionLog->setCronLog($cronLogEntity);
            $this->em->persist($transactionLog);

            $transactionLogs[] = $transactionLog;
        }

        $this->em->flush();
    }

    /**
     * @throws OutOfBoundsException If no data found in cron log.
     * @throws UnexpectedValueException If provided date in wrong format.
     *
     * @return \DateTimeInterface
     */
    private function getDateTimeFrom()
    {
        $providedDate = $this->option('date-time-from');

        if ($providedDate == 'default') {
            /** @var ApiCronLog $cronLog */
            $cronLogs = $this->cronRepository->findBy(
                ['command' => self::API_COMMAND_NAME],
                ['rangeFrom' => 'DESC'],
                1
            );

            if (empty($cronLogs)) {
                throw new OutOfBoundsException(
                    sprintf(
                        'There is no log entry for this command, you should specify the from date. [command: %s]',
                        self::API_COMMAND_NAME
                    )
                );
            }
            $cronLog = current($cronLogs);

            return $cronLog->getRangeTo();
        }

        return $this->getDateFromString($providedDate);
    }

    /**
     * @return \DateTimeInterface
     */
    private function getDateTimeTo()
    {
        $providedDate = $this->option('date-time-to');

        if ($providedDate == 'default') {
            return new DateTime();
        }

        return $this->getDateFromString($providedDate);

    }

    /**
     * @param string $providedDate
     *
     * @throws \InvalidArgumentException Id date is not a string.
     * @throws \UnexpectedValueException If date is in wrong format.
     *
     * @return DateTime
     */
    private function getDateFromString($providedDate)
    {
        TypeChecker::assertString($providedDate, '$providedDate');

        $dateTo = DateTime::createFromFormat(self::DATE_FORMAT, $providedDate);

        if (!$dateTo) {
            throw new UnexpectedValueException(
                sprintf(
                    'date-time-to provided in wrong format. [provided: %s, right format: %s]',
                    $providedDate,
                    self::DATE_FORMAT
                )
            );
        }

        return $dateTo;
    }
}
