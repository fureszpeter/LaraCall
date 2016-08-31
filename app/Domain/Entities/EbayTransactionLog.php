<?php
namespace LaraCall\Domain\Entities;

use DateTimeInterface;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Event;
use Furesz\TypeChecker\TypeChecker;
use LaraCall\Domain\Events\TransactionLogCreatedEvent;
use LaraCall\Domain\Events\TransactionStatusChangedEvent;
use LaraCall\Domain\ValueObjects\OrderStatusVO;

/**
 * Class EbayTransactionLog.
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class EbayTransactionLog extends AbstractEntity
{
    /**
     * @var bool
     */
    protected $statusUpdated = false;

    /**
     * @var string
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(name="transaction_id", type="string", unique=true, nullable=false)
     */
    private $transactionId;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    protected $itemId;

    /**
     * @var int|null
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $quantity;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $soldPricePerItem;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $amountPayed;

    /**
     * @var string
     */
    protected $sellerUserName;

    /**
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $transactionDate;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=false)
     */
    protected $transactionData;

    /**
     * @var EbaySyncLog|null
     *
     * @ORM\ManyToOne(targetEntity="EbaySyncLog")
     * @ORM\JoinColumn(name="sync_id", referencedColumnName="id" , nullable=true)
     */
    protected $syncLog;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64, nullable=false)
     */
    protected $orderStatus = OrderStatusVO::STATUS_RECEIVED;

    /**
     * @param string            $transactionId
     * @param string            $sellerUserName
     * @param DateTimeInterface $transactionDate
     * @param string            $transactionData
     */
    public function __construct(
        $transactionId,
        $sellerUserName,
        DateTimeInterface $transactionDate,
        $transactionData
    ) {
        TypeChecker::assertString($transactionId, '$transactionId');
        TypeChecker::assertString($sellerUserName, '$sellerUserName');
        TypeChecker::assertString($transactionData, '$transactionData');

        parent::__construct();

        $this->transactionId   = $transactionId;
        $this->sellerUserName  = $sellerUserName;
        $this->transactionDate = $transactionDate;
        $this->transactionData = $transactionData;
    }

    /**
     * @param PreUpdateEventArgs $args
     *
     * @ORM\PreUpdate()
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        if ($args->hasChangedField('orderStatus') && $this->getItemId()){
            $this->statusUpdated = true;
        }
    }

    /**
     * @ORM\PostUpdate()
     */
    public function postUpdate()
    {
        if ($this->statusUpdated) {
            Event::fire(
                new TransactionStatusChangedEvent($this->getItemId(), $this->getOrderStatus())
            );

            $this->statusUpdated = false;
        }
    }

    /**
     * @ORM\PostPersist()
     */
    public function fireEventOnPostPersist()
    {
        Event::fire(new TransactionLogCreatedEvent($this));
    }

    /**
     * @param null|string $itemId
     *
     * @return $this
     */
    public function setItemId($itemId)
    {
        TypeChecker::assertString($itemId, '$itemId');

        $this->itemId = $itemId;

        return $this;
    }

    /**
     * @param int|null $quantity
     *
     * @return $this
     */
    public function setQuantity($quantity)
    {
        TypeChecker::assertInteger($quantity, '$quantity');

        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @param null|float $amountPayed
     *
     * @return $this
     */
    public function setAmountPayed($amountPayed)
    {
        TypeChecker::assertDouble($amountPayed, '$amountPayed');

        $this->amountPayed = (string)$amountPayed;

        return $this;
    }

    /**
     * @param string $soldPricePerItem
     *
     * @return $this
     */
    public function setSoldPricePerItem($soldPricePerItem)
    {
        $this->soldPricePerItem = $soldPricePerItem;

        return $this;
    }

    /**
     * @param EbaySyncLog|null $syncLog
     *
     * @return $this
     */
    public function setSyncLog(EbaySyncLog $syncLog)
    {
        $this->syncLog = $syncLog;

        return $this;
    }

    /**
     * @return string
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @return null|string
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * @return int|null
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return null|string
     */
    public function getAmountPayed()
    {
        return $this->amountPayed;
    }

    /**
     * @return EbaySyncLog|null
     */
    public function getSyncLog()
    {
        return $this->syncLog;
    }

    /**
     * @return string
     */
    public function getSellerUserName()
    {
        return $this->sellerUserName;
    }

    /**
     * @return DateTimeInterface
     */
    public function getTransactionDate()
    {
        return $this->transactionDate;
    }

    /**
     * @return string
     */
    public function getSoldPricePerItem()
    {
        return $this->soldPricePerItem;
    }

    /**
     * @return string
     */
    public function getTransactionData()
    {
        return $this->transactionData;
    }

    /**
     * @return string
     */
    public function getOrderStatus()
    {
        return $this->orderStatus;
    }

    /**
     * @param OrderStatusVO $orderStatus
     *
     * @return $this
     */
    public function setOrderStatus(OrderStatusVO $orderStatus)
    {
        $this->orderStatus = $orderStatus->getStatus();

        return $this;
    }
}
