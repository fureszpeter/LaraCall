<?php

namespace LaraCall\Events;

class PaymentCompleteEvent extends Event
{
    /**
     * @var int
     */
    private $paymentTransactionId;

    /**
     * Create a new event instance.
     *
     * @param int $paymentTransactionId
     */
    public function __construct(int $paymentTransactionId)
    {
        $this->paymentTransactionId = $paymentTransactionId;
    }

    /**
     * @return int
     */
    public function getPaymentTransactionId(): int
    {
        return $this->paymentTransactionId;
    }
}
