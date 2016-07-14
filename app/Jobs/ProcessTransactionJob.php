<?php


namespace LaraCall\Jobs;

use LaraCall\Domain\Entities\EbayTransactionLog;

/**
 * Class ProcessTransactionJob
 *
 * @package LaraCall\Jobs
 */
class ProcessTransactionJob
{
    /**
     * @var EbayTransactionLog
     */
    private $transactionLog;

    /**
     * @param EbayTransactionLog $transactionLog
     */
    public function __construct(EbayTransactionLog $transactionLog)
    {
        $this->transactionLog = $transactionLog;
    }

    public function handle()
    {
        echo 'handling transaction: ' . $this->transactionLog->getOrderStatus();
    }
}
