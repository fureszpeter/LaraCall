<?php
namespace LaraCall\Domain\PayPal\ValueObjects;

use LaraCall\Infrastructure\Services\Ebay\ValueObjects\ItemId;

class EbayTransaction
{
    /**
     * @var ItemId
     */
    private $itemId;

    /**
     * @var string
     */
    private $ebayTxnId;

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
     * @var string
     */
    private $itemName;

    /**
     * @param ItemId $itemId
     * @param string $itemName
     * @param string $ebayTxnId
     * @param int    $quantity
     * @param string $amountPaid
     * @param string $currency
     */
    public function __construct(
        ItemId $itemId,
        string $itemName,
        string $ebayTxnId,
        int $quantity,
        string $amountPaid,
        string $currency
    ) {
        $this->itemId     = $itemId;
        $this->ebayTxnId  = $ebayTxnId;
        $this->amountPaid = $amountPaid;
        $this->currency   = $currency;
        $this->quantity   = $quantity;
        $this->itemName   = $itemName;
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
        return sprintf('%s-%s', $this->getItemId(), $this->getEbayTxnId());
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
    public function getEbayTxnId(): string
    {
        return $this->ebayTxnId;
    }

    public function getItemName(): string
    {
        return $this->itemName;
    }
}
