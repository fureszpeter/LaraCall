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
use LaraCall\Domain\ValueObjects\DateTime as DateTimeVo;
use LaraCall\Domain\ValueObjects\EbayConfig;
use LaraCall\Domain\ValueObjects\OrderStatusVO;
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
class RecheckTransactions extends Command
{
    const API_COMMAND_NAME = 'getSellerTransactions';
    const DATE_FORMAT      = 'Y-m-d\TH:i:s';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ebay:transactions:recheck';

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
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    protected $transactionLogRepository;

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

        $this->tradingService           = $tradingService;
        $this->ebayService              = $ebayService;
        $this->em                       = $em;
        $this->cronRepository           = $this->em->getRepository(ApiCronLog::class);
        $this->transactionLogRepository = $this->em->getRepository(EbayTransactionLog::class);
        $this->ebayConfig               = $ebayConfig;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /** @var EbayTransactionLog[] $transactions */
        $transactions = $this->transactionLogRepository->findBy([
            'orderStatus' => OrderStatusVO::STATUS_WAIT_FOR_PAYMENT()
        ]);

        $orders = $this->ebayService->getOrderTransaction(...$transactions);

        dd($orders);
    }
}
