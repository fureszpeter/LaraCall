<?php
namespace LaraCall\Domain\Entities;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use LaraCall\Domain\Collections\EbayUserCollection;
use LaraCall\Domain\Collections\PinCollection;

/**
 * Class SubscriptionEntity.
 *
 * @package LaraCall
 *
 * @license Proprietary
 *
 * @ORM\Entity(repositoryClass="LaraCall\Infrastructure\Repositories\DoctrineSubscriptionRepository")
 */
class Subscription extends AbstractEntityWithId implements JsonSerializable
{
    /**
     * @var User
     *
     * @ORM\OneToOne(targetEntity="User", inversedBy="subscription", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false, unique=true)
     */
    protected $user;

    /**
     * @var EbayUser[]|EbayUserCollection
     *
     * @ORM\OneToMany(targetEntity="EbayUser", mappedBy="subscription", cascade={"persist"})
     */
    protected $ebayUsers;

    /**
     * @var Pin[]|PinCollection
     *
     * @ORM\OneToMany(targetEntity="Pin", mappedBy="subscription", cascade={"persist"})
     */
    protected $pins;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $defaultPin;

    /**
     * @var PaymentTransaction[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="PaymentTransaction", mappedBy="subscription")
     */
    protected $payments;

    /**
     * @var EbayPaymentTransaction[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="EbayPaymentTransaction", mappedBy="subscription")
     */
    protected $ebayPayments;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $lastName;

    /**
     * @var Country
     *
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="isoAlpha3")
     * @ORM\JoinColumn(name="isoAlpha3", referencedColumnName="isoAlpha3")
     */
    protected $country;

    /**
     * @var State
     *
     * @ORM\ManyToOne(targetEntity="State", inversedBy="stateCode")
     * @ORM\JoinColumn(name="stateCode", referencedColumnName="stateCode")
     */
    protected $state;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $city;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $address1;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $address2;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $packageId;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetimetz", nullable=false)
     */
    protected $dateLastPurchase;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $numberOfRefill = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $numberOfRefund = 0;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $lastTransactionAmount = "0";

    /**
     * @param User              $userEntity
     * @param Country           $country
     * @param string            $firstName
     * @param string            $lastName
     * @param string            $zipCode
     * @param string            $city
     * @param string            $address1
     * @param int               $tariffCode
     * @param string            $address2
     * @param State             $state
     * @param DateTimeInterface $dateLastPurchase
     */
    public function __construct(
        User $userEntity,
        Country $country,
        string $firstName,
        string $lastName,
        string $zipCode,
        string $city,
        string $address1,
        int $tariffCode,
        string $address2 = null,
        State $state = null,
        DateTimeInterface $dateLastPurchase = null
    ) {
        parent::__construct();

        $this->pins = new PinCollection();

        $this->user = $userEntity;

        $this->country = $country;
        $this->state   = $state;

        $this->firstName = $firstName;
        $this->lastName  = $lastName;
        $this->zipCode   = $zipCode;
        $this->address1  = $address1;
        $this->address2  = $address2;
        $this->packageId = $tariffCode;

        $this->payments         = new ArrayCollection();
        $this->ebayUsers        = new EbayUserCollection();
        $this->city             = $city;
        $this->dateLastPurchase = $dateLastPurchase ?: new DateTime();
    }

    /**
     * @return ArrayCollection|PaymentTransaction[]
     */
    public function getPayments()
    {
        return $this->payments;
    }

    /**
     * @return Pin|null
     */
    public function getDefaultPin(): ?Pin
    {
        if ( ! $this->defaultPin) {
            return null;
        }

        return $this->getPins()->findByPin($this->defaultPin);
    }

    /**
     * @param Pin $defaultPin
     *
     * @return Subscription
     */
    public function setDefaultPin(Pin $defaultPin): self
    {
        if ( ! $this->getPins()->findByPin($defaultPin->getPin())) {
            $pins = $this->getPins();
            $pins->add($defaultPin);
            $this->pins = $pins;
        }

        $this->defaultPin = $defaultPin->getPin();

        return $this;
    }

    /**
     * @return PinCollection|Pin[]
     */
    public function getPins()
    {
        return new PinCollection($this->pins->toArray());
    }

    /**
     * @return DateTime
     */
    public function getDateLastPurchase(): DateTime
    {
        return $this->dateLastPurchase;
    }

    /**
     * @param DateTimeInterface $dateOfPayment
     *
     * @param float             $amount
     *
     * @return $this
     */
    public function addPaymentEvent(DateTimeInterface $dateOfPayment, float $amount)
    {
        $this->dateLastPurchase      = $dateOfPayment;
        $this->lastTransactionAmount = (string)$amount;

        if ($amount < 0) {
            $this->numberOfRefund++;
        } else {
            $this->numberOfRefill++;
        }

        return $this;
    }

    /**
     * @param EbayUser $ebayUser
     *
     * @return $this
     */
    public function setEbayUser(EbayUser $ebayUser)
    {
        $this->getEbayUsers()->add($ebayUser);

        return $this;
    }

    /**
     * @return EbayUser[]|EbayUserCollection
     */
    public function getEbayUsers()
    {
        return new EbayUserCollection($this->ebayUsers->toArray());
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->country;
    }

    /**
     * @return State|null
     */
    public function getState(): ?State
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    /**
     * @return string
     */
    public function getAddress1(): string
    {
        return $this->address1;
    }

    /**
     * @return string
     */
    public function getAddress2(): string
    {
        return $this->address2;
    }

    /**
     * @return int
     */
    public function getPackageId(): int
    {
        return $this->packageId;
    }

    /**
     * @return bool
     */
    public function isBlocked(): bool
    {
        return $this->getUser()->isBlocked();
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param DateTimeInterface $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(DateTimeInterface $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @param DateTimeInterface $dateLastPurchase
     *
     * @return $this
     */
    public function setDateLastPurchase(DateTimeInterface $dateLastPurchase)
    {
        $this->dateLastPurchase = $dateLastPurchase;

        return $this;
    }

    /**
     * @return ArrayCollection|EbayPaymentTransaction[]
     */
    public function getEbayPayments()
    {
        return $this->ebayPayments;
    }

    /**
     * @return int
     */
    public function getNumberOfRefill(): int
    {
        return $this->numberOfRefill;
    }

    /**
     * @return int
     */
    public function getNumberOfRefund(): int
    {
        return $this->numberOfRefund;
    }

    /**
     * @return $this
     */
    public function increaseRefund()
    {
        $this->numberOfRefund++;

        return $this;
    }

    public function increaseRefill()
    {
        $this->numberOfRefill++;

        return $this;
    }

    /**
     * @param string $lastTransactionAmount
     *
     * @return $this
     */
    public function setLastTransactionAmount($lastTransactionAmount)
    {
        $this->lastTransactionAmount = $lastTransactionAmount;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastTransactionAmount(): string
    {
        return $this->lastTransactionAmount;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id'       => $this->getId(),
            'address1' => $this->getAddress1(),
            'address2' => $this->getAddress2(),
            'city'     => $this->getCity(),
            'country'  => $this->getCountry(),
            'state'    => $this->getState(),

        ];
    }
}
