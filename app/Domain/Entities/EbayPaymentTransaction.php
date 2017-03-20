<?php
namespace LaraCall\Domain\Entities;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use LaraCall\Infrastructure\Services\Ebay\ValueObjects\ItemId;

/**
 * Class EbayPaymentTransaction.
 *
 * @package LaraCall
 *
 * @license Proprietary
 *
 * @ORM\Entity(repositoryClass="LaraCall\Infrastructure\Repositories\DoctrineEbayPaymentTransactionRepository")
 */
class EbayPaymentTransaction extends AbstractEntityWithId implements JsonSerializable
{
    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $newSubscription;

    /**
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetimetz", nullable=false)
     */
    protected $datePayment;

    /**
     * @var EbayUser
     * @ORM\ManyToOne(targetEntity="EbayUser", inversedBy="id")
     */
    protected $ebayUser;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $ebayToken;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $ebayUsername;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $itemId;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $transactionId;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=false)
     */
    protected $itemValue;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $itemName;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $quantity;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $mcGross;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $mcCurrency;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=false)
     */
    protected $amountInUsd;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $buyerFirstName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $buyerLastName;

    /**
     * @var Country
     *
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="isoAlpha3")
     * @ORM\JoinColumn(name="buyerCountry", referencedColumnName="isoAlpha3")
     */
    protected $buyerCountry;

    /**
     * @var State|null
     *
     * @ORM\ManyToOne(targetEntity="State", inversedBy="stateCode")
     * @ORM\JoinColumn(name="stateCode", referencedColumnName="stateCode")
     */
    protected $buyerState;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $buyerZip;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $buyerAddress;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $buyerEmail;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $receiverEmail;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=false)
     */
    protected $paymentFee;

    /**
     * @var Subscription
     *
     * @ORM\ManyToOne(targetEntity="Subscription")
     */
    protected $subscription;

    /**
     * @var string
     */
    private $city;

    /**
     * @param bool              $newSubscription
     * @param DateTimeInterface $datePayment
     * @param EbayUser          $ebayUser
     * @param ItemId            $itemId
     * @param string            $transactionId
     * @param float             $itemValue
     * @param string            $itemName
     * @param int               $quantity
     * @param float             $mcGross
     * @param string            $mcCurrency
     * @param float             $amountInUsd
     * @param string            $buyerFirstName
     * @param string            $buyerLastName
     * @param Country           $buyerCountry
     * @param string            $buyerZip
     * @param string            $city
     * @param string            $buyerAddress
     * @param string            $buyerEmail
     * @param string            $receiverEmail
     * @param float             $paymentFee
     * @param Subscription      $subscription
     * @param State|null        $buyerState
     */
    public function __construct(
        bool $newSubscription,
        DateTimeInterface $datePayment,
        EbayUser $ebayUser,
        ItemId $itemId,
        string $transactionId,
        float $itemValue,
        string $itemName,
        int $quantity,
        float $mcGross,
        string $mcCurrency,
        float $amountInUsd,
        string $buyerFirstName,
        string $buyerLastName,
        Country $buyerCountry,
        string $buyerZip,
        string $city,
        string $buyerAddress,
        string $buyerEmail,
        string $receiverEmail,
        float $paymentFee,
        Subscription $subscription,
        State $buyerState = null
    ) {
        parent::__construct();

        $this->newSubscription = $newSubscription;
        $this->datePayment     = $datePayment;
        $this->ebayToken       = $ebayUser->getEbayUserTokenId();
        $this->ebayUsername    = $ebayUser->getEbayUserId();
        $this->itemId          = $itemId->getItemId();
        $this->ebayUser        = $ebayUser;
        $this->transactionId   = $transactionId;
        $this->itemValue       = $itemValue;
        $this->itemName        = $itemName;
        $this->quantity        = $quantity;
        $this->mcGross         = $mcGross;
        $this->mcCurrency      = $mcCurrency;
        $this->amountInUsd     = $amountInUsd;
        $this->buyerFirstName  = $buyerFirstName;
        $this->buyerLastName   = $buyerLastName;
        $this->buyerCountry    = $buyerCountry;
        $this->buyerState      = $buyerState;
        $this->buyerZip        = $buyerZip;
        $this->buyerAddress    = $buyerAddress;
        $this->buyerEmail      = $buyerEmail;
        $this->receiverEmail   = $receiverEmail;
        $this->paymentFee      = $paymentFee;
        $this->subscription    = $subscription;
        $this->city            = $city;
    }

    /**
     * @return Subscription
     */
    public function getSubscription(): Subscription
    {
        return $this->subscription;
    }

    /**
     * @return array;
     */
    function jsonSerialize()
    {
        return [
            'newSubscription' => $this->isNewSubscription(),
            'datePayment'     => $this->getDatePayment(),
            'ebayUser'        => $this->getEbayUser(),
            'ebayToken'       => $this->getEbayToken(),
            'ebayUsername'    => $this->getEbayUsername(),
            'itemId'          => $this->getItemId(),
            'transactionId'   => $this->getTransactionId(),
            'itemValue'       => $this->getItemValue(),
            'itemName'        => $this->getItemName(),
            'quantity'        => $this->getQuantity(),
            'mcGross'         => $this->getMcGross(),
            'mcCurrency'      => $this->getMcCurrency(),
            'amountInUsd'     => $this->getAmountInUsd(),
            'buyerFirstName'  => $this->getBuyerFirstName(),
            'buyerLastName'   => $this->getBuyerLastName(),
            'buyerCountry'    => $this->getBuyerCountry(),
            'buyerState'      => $this->getBuyerState(),
            'buyerZip'        => $this->getBuyerZip(),
            'buyerAddress'    => $this->getBuyerAddress(),
            'buyerEmail'      => $this->getBuyerEmail(),
            'receiverEmail'   => $this->getReceiverEmail(),
            'paymentFee'      => $this->getPaymentFee(),
            'city'            => $this->getCity(),
        ];
    }

    /**
     * @return bool
     */
    public function isNewSubscription(): bool
    {
        return $this->newSubscription;
    }

    /**
     * @return DateTimeInterface
     */
    public function getDatePayment(): DateTimeInterface
    {
        return $this->datePayment;
    }

    /**
     * @return EbayUser
     */
    public function getEbayUser(): EbayUser
    {
        return $this->ebayUser;
    }

    /**
     * @return string
     */
    public function getEbayToken(): string
    {
        return $this->ebayToken;
    }

    /**
     * @return string
     */
    public function getEbayUsername(): string
    {
        return $this->ebayUsername;
    }

    /**
     * @return ItemId
     */
    public function getItemId(): ItemId
    {
        return new ItemId($this->itemId);
    }

    /**
     * @return string
     */
    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    /**
     * @return float
     */
    public function getItemValue(): float
    {
        return $this->itemValue;
    }

    /**
     * @return string
     */
    public function getItemName(): string
    {
        return $this->itemName;
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
    public function getMcGross(): string
    {
        return $this->mcGross;
    }

    /**
     * @return string
     */
    public function getMcCurrency(): string
    {
        return $this->mcCurrency;
    }

    /**
     * @return float
     */
    public function getAmountInUsd(): float
    {
        return $this->amountInUsd;
    }

    /**
     * @return string
     */
    public function getBuyerFirstName(): string
    {
        return $this->buyerFirstName;
    }

    /**
     * @return string
     */
    public function getBuyerLastName(): string
    {
        return $this->buyerLastName;
    }

    /**
     * @return Country
     */
    public function getBuyerCountry(): Country
    {
        return $this->buyerCountry;
    }

    /**
     * @return State|null
     */
    public function getBuyerState()
    {
        return $this->buyerState;
    }

    /**
     * @return string
     */
    public function getBuyerZip(): string
    {
        return $this->buyerZip;
    }

    /**
     * @return string
     */
    public function getBuyerAddress(): string
    {
        return $this->buyerAddress;
    }

    /**
     * @return string
     */
    public function getBuyerEmail(): string
    {
        return $this->buyerEmail;
    }

    /**
     * @return string
     */
    public function getReceiverEmail(): string
    {
        return $this->receiverEmail;
    }

    /**
     * @return float
     */
    public function getPaymentFee(): float
    {
        return $this->paymentFee;
    }

    /**
     * @return string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }
}
