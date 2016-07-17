<?php
namespace LaraCall\Domain\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use Furesz\TypeChecker\TypeChecker;
use LaraCall\Domain\Entities\EbayListing;

class TransactionParseResult
{
    /**
     * @var OrderStatusVO
     */
    private $orderStatusVO;

    /**
     * @var string
     */
    private $itemId;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var float
     */
    private $soldPricePerItem;

    /**
     * @var float
     */
    private $amountPayed;

    /**
     * @param OrderStatusVO $orderStatusVO
     * @param string        $itemId
     * @param int           $quantity
     * @param double        $soldPricePerItem
     * @param double        $amountPayed
     */
    public function __construct(
        OrderStatusVO $orderStatusVO,
        $itemId,
        $quantity,
        $soldPricePerItem,
        $amountPayed
    ) {
        TypeChecker::assertString($itemId, '$itemId');
        TypeChecker::assertInteger($quantity, '$quantity');
        TypeChecker::assertDouble($soldPricePerItem, '$soldPricePerItem');
        TypeChecker::assertDouble($amountPayed, '$amountPayed');

        $this->orderStatusVO = $orderStatusVO;
        $this->itemId        = $itemId;
        $this->quantity      = $quantity;
        $this->amountPayed   = $amountPayed;
        $this->soldPricePerItem = $soldPricePerItem;
    }

    /**
     * @return OrderStatusVO
     */
    public function getOrderStatusVO()
    {
        return $this->orderStatusVO;
    }

    /**
     * @return string
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return float
     */
    public function getSoldPricePerItem()
    {
        return $this->soldPricePerItem;
    }

    /**
     * @return float
     */
    public function getAmountPayed()
    {
        return $this->amountPayed;
    }
}
