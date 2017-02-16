<?php
namespace LaraCall\Domain\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class EbayPaymentTransaction.
 *
 * @package LaraCall
 *
 * @license Proprietary
 *
 * @ORM\Entity()
 */
class EbayPaymentTransaction extends AbstractEntityWithId
{
    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetimetz", nullable=false)
     */
    protected $datePayment;

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
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="countryCode")
     * @ORM\JoinColumn(name="countryCode", referencedColumnName="countryCode")
     */
    protected $buyerCountry;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
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
     * @param DateTime     $datePayment
     * @param string       $ebayToken
     * @param string       $ebayUsername
     * @param string       $itemId
     * @param string       $transactionId
     * @param float        $itemValue
     * @param string       $itemName
     * @param int          $quantity
     * @param string       $mcGross
     * @param string       $mcCurrency
     * @param float        $amountInUsd
     * @param string       $buyerFirstName
     * @param string       $buyerLastName
     * @param string       $buyerCountry
     * @param string       $buyerZip
     * @param string       $buyerAddress
     * @param string       $buyerEmail
     * @param string       $receiverEmail
     * @param float        $paymentFee
     * @param Subscription $subscription
     * @param null|string  $buyerState
     */
    public function __construct(
        DateTime $datePayment,
        $ebayToken,
        $ebayUsername,
        $itemId,
        $transactionId,
        $itemValue,
        $itemName,
        $quantity,
        $mcGross,
        $mcCurrency,
        $amountInUsd,
        $buyerFirstName,
        $buyerLastName,
        $buyerCountry,
        $buyerZip,
        $buyerAddress,
        $buyerEmail,
        $receiverEmail,
        $paymentFee,
        Subscription $subscription,
        $buyerState = null
    ) {
        $this->datePayment    = $datePayment;
        $this->ebayToken      = $ebayToken;
        $this->ebayUsername   = $ebayUsername;
        $this->itemId         = $itemId;
        $this->transactionId  = $transactionId;
        $this->itemValue      = $itemValue;
        $this->itemName       = $itemName;
        $this->quantity       = $quantity;
        $this->mcGross        = $mcGross;
        $this->mcCurrency     = $mcCurrency;
        $this->amountInUsd    = $amountInUsd;
        $this->buyerFirstName = $buyerFirstName;
        $this->buyerLastName  = $buyerLastName;
        $this->buyerCountry   = $buyerCountry;
        $this->buyerState     = $buyerState;
        $this->buyerZip       = $buyerZip;
        $this->buyerAddress   = $buyerAddress;
        $this->buyerEmail     = $buyerEmail;
        $this->receiverEmail  = $receiverEmail;
        $this->paymentFee     = $paymentFee;
        $this->subscription   = $subscription;
    }

    /**
     * @return DateTime
     */
    public function getDatePayment(): DateTime
    {
        return $this->datePayment;
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
     * @return string
     */
    public function getItemId(): string
    {
        return $this->itemId;
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
     * @return string
     */
    public function getBuyerCountry(): string
    {
        return $this->buyerCountry;
    }

    /**
     * @return null|string
     */
    public function getBuyerState(): ?string
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
     * @return Subscription
     */
    public function getSubscription(): Subscription
    {
        return $this->subscription;
    }
}
