<?php
namespace LaraCall\Domain\Entities;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use LaraCall\Domain\ValueObjects\PaymentSource;

/**
 * Class RefillEntity.
 *
 * @package LaraCall
 *
 * @license Proprietary
 *
 * @ORM\Entity(repositoryClass="LaraCall\Infrastructure\Repositories\DoctrinePaymentTransactionRepository")
 */
class PaymentTransaction extends AbstractEntityWithId
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $amountPayed;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    protected $currency;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $convertedAmount;

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
    protected $source;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetimetz", nullable=false)
     */
    protected $dateOfPayment;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    private $refillValue;

    /**
     * @var Pin
     *
     * @ORM\ManyToOne(targetEntity="Pin")
     * @ORM\JoinColumn(name="pin", referencedColumnName="pin")
     */
    private $pin;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $remoteTransactionId;

    /**
     * @param Pin               $pin
     * @param int               $quantity
     * @param string            $amountPayed
     * @param string            $currency
     * @param string            $convertedAmount
     * @param string            $refillValue
     * @param PaymentSource     $source
     * @param DateTimeInterface $dateOfPayment
     * @param string|null       $remoteTransactionId
     */
    public function __construct(
        Pin $pin,
        int $quantity,
        string $amountPayed,
        string $currency,
        string $convertedAmount,
        string $refillValue,
        PaymentSource $source,
        DateTimeInterface $dateOfPayment = null,
        string $remoteTransactionId = null
    ) {
        parent::__construct();

        $this->pin                 = $pin;
        $this->amountPayed         = $amountPayed;
        $this->currency            = $currency;
        $this->convertedAmount     = $convertedAmount;
        $this->source              = $source;
        $this->refillValue         = $refillValue;
        $this->quantity            = $quantity;
        $this->dateOfPayment       = $dateOfPayment ?: new DateTime();
        $this->remoteTransactionId = $remoteTransactionId;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
    public function getRefillValue(): string
    {
        return $this->refillValue;
    }

    /**
     * @return string
     */
    public function getAmountPayed(): string
    {
        return $this->amountPayed;
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
    public function getConvertedAmount(): string
    {
        return $this->convertedAmount;
    }

    /**
     * @return PaymentSource
     */
    public function getSource(): PaymentSource
    {
        return new PaymentSource($this->source);
    }

    /**
     * @return DateTimeInterface
     */
    public function getDateOfPayment(): DateTimeInterface
    {
        return $this->dateOfPayment;
    }

    /**
     * @return Pin
     */
    public function getPin(): Pin
    {
        return $this->pin;
    }

    /**
     * @return string|null
     */
    public function getRemoteTransactionId(): ?string
    {
        return $this->remoteTransactionId;
    }
}
