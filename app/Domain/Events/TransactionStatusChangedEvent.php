<?php
namespace LaraCall\Domain\Events;

class TransactionStatusChangedEvent
{
    private $transactionLogId;

    private $newStatus;

    /**
     * @param $transactionLogId
     * @param $newStatus
     */
    public function __construct($transactionLogId, $newStatus)
    {
        $this->transactionLogId = $transactionLogId;
        $this->newStatus = $newStatus;
    }

    /**
     * @return mixed
     */
    public function getTransactionLogId()
    {
        return $this->transactionLogId;
    }

    /**
     * @return mixed
     */
    public function getNewStatus()
    {
        return $this->newStatus;
    }
}
