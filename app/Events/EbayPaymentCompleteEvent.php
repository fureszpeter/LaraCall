<?php

namespace LaraCall\Events;

class EbayPaymentCompleteEvent extends Event
{
    /**
     * @var int
     */
    private $ebayPaymentTransactionId;

    /**
     * Create a new event instance.
     *
     * @param int $ebayPaymentTransactionId
     */
    public function __construct(int $ebayPaymentTransactionId)
    {
        $this->ebayPaymentTransactionId = $ebayPaymentTransactionId;
    }

    /**
     * @return int
     */
    public function getEbayPaymentTransactionId(): int
    {
        return $this->ebayPaymentTransactionId;
    }
}
