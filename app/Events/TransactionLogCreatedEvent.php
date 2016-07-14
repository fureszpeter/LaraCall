<?php


namespace LaraCall\Events;

use LaraCall\Domain\Entities\EbayTransactionLog;

/**
 * Class TransactionLogCreated
 *
 * @package LaraCall\Events
 */
class TransactionLogCreatedEvent
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

    /**
     * @return EbayTransactionLog
     */
    public function getTransactionLog()
    {
        return $this->transactionLog;
    }
}
