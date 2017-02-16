<?php
namespace LaraCall\Domain\Entities;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
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
class Subscription extends AbstractEntityWithId
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
     * @ORM\ManyToOne(targetEntity="Country")
     */
    protected $country;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $countryIsoAlpha3;

    /**
     * @var State
     *
     * @ORM\ManyToOne(targetEntity="State")
     */
    protected $state;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $stateName;

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
     * @param Country           $countryEntity
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
        Country $countryEntity,
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

        $this->country          = $countryEntity;
        $this->countryIsoAlpha3 = $countryEntity->getIsoAlpha3();
        $this->state            = $state;
        $this->stateName        = $state ? $state->getStateName() : null;

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
     * @return Pin
     */
    public function getDefaultPin(): Pin
    {
        return $this->getPins()->findByPin($this->defaultPin);
    }

    /**
     * @param Pin $defaultPin
     *
     * @return Subscription
     */
    public function setDefaultPin(Pin $defaultPin): self
    {
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
        $this->lastTransactionAmount = (string) $amount;

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
}
