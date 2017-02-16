<?php
namespace LaraCall\Domain\PayPal\ValueObjects;

use LaraCall\Infrastructure\Services\Ebay\ValueObjects\ItemId;

class PayPalIpnEbayTransactionDetails
{
    /**
     * @var ItemId
     */
    private $itemId;

    /**
     * @var string
     */
    private $txnId;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var string
     */
    private $amountPaid;

    /**
     * @var string
     */
    private $currency;

    /**
     * @param ItemId $itemId
     * @param string $txnId
     * @param int    $quantity
     * @param string $amountPaid
     * @param string $currency
     */
    public function __construct(
        ItemId $itemId,
        string $txnId,
        int $quantity,
        string $amountPaid,
        string $currency
    ) {
        $this->itemId     = $itemId;
        $this->txnId      = $txnId;
        $this->amountPaid = $amountPaid;
        $this->currency   = $currency;
        $this->quantity = $quantity;
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
    public function getAmountPaid(): string
    {
        return $this->amountPaid;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s-%s', $this->getItemId(), $this->getTxnId());
    }

    /**
     * @return ItemId
     */
    public function getItemId(): ItemId
    {
        return $this->itemId;
    }

    /**
     * @return string
     */
    public function getTxnId(): string
    {
        return $this->txnId;
    }
}
