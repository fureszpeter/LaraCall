<?php
namespace LaraCall\Domain\ValueObjects;

class PaymentTransaction
{
    /**
     * @var string
     */
    private $itemId;

    /**
     * @var float
     */
    private $payedAmount;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var string
     */
    private $transactionId;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @param string $transactionId
     * @param string $itemId
     * @param int    $quantity
     * @param float  $payedAmount
     * @param string $currency
     */
    public function __construct(
        string $transactionId,
        string $itemId,
        int $quantity,
        float $payedAmount,
        string $currency
    ) {
        $this->itemId        = $itemId;
        $this->payedAmount   = $payedAmount;
        $this->currency      = $currency;
        $this->transactionId = $transactionId;
        $this->quantity      = $quantity;
    }

    /**
     * @return string
     */
    public function getItemId(): string
    {
        return $this->itemId;
    }

    /**
     * @return float
     */
    public function getPayedAmount(): float
    {
        return $this->payedAmount;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
