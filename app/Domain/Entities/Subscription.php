<?php
namespace LaraCall\Domain\Entities;

use Carbon\Carbon;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use LaraCall\Domain\ValueObjects\Pin;
use ValueObjects\Money\Money;

/**
 * Class Subscription.
 *
 * @package LaraCall
 *
 * @license Proprietary
 *
 * @ORM\Entity()
 */
class Subscription extends AbstractEntityWithId implements JsonSerializable
{
    /**
     * @var User
     *
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @var Pin
     *
     * @ORM\Column(type="string", length=10, unique=true, nullable=false)
     */
    protected $pin;

    /**
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $subscriptionCreationDate;

    /**
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $expirationDate;

    /**
     * @var DateTimeInterface|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $lastRefillDate;

    /**
     * @var string|null
     *
     * @ORM\Column(type="decimal", precision=19, scale=4, nullable=true)
     */
    protected $lastRefillAmount;

    /**
     * @param User $user
     * @param Pin  $pin
     */
    public function __construct(User $user, Pin $pin)
    {
        parent::__construct();

        $this->user                     = $user;
        $this->pin                      = $pin;
        $this->subscriptionCreationDate = $this->getCreatedAt();
        $this->expirationDate           = Carbon::now()->addYear(1);
    }

    /**
     * @return DateTimeInterface
     */
    public function getSubscriptionCreationDate()
    {
        return $this->subscriptionCreationDate;
    }

    /**
     * @param DateTimeInterface $subscriptionCreationDate
     *
     * @return $this
     */
    public function setSubscriptionCreationDate(DateTimeInterface $subscriptionCreationDate)
    {
        $this->subscriptionCreationDate = $subscriptionCreationDate;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * @param DateTimeInterface $expirationDate
     *
     * @return $this
     */
    public function setExpirationDate(DateTimeInterface $expirationDate)
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getLastRefillDate()
    {
        return $this->lastRefillDate;
    }

    /**
     * @return string|null
     */
    public function getLastRefillAmount()
    {
        return $this->lastRefillAmount;
    }

    /**
     * @return Pin
     */
    public function getPin()
    {
        if ($this->pin instanceof Pin) {
            return $this->pin;
        } else {
            return $this->pin = new Pin($this->pin);
        }
    }

    /**
     * @param Pin $pin
     *
     * @return $this
     */
    public function setPin(Pin $pin)
    {
        $this->pin = $pin;

        return $this;
    }

    /**
     * @param Money $money
     */
    public function refill(Money $money)
    {
        $this->lastRefillAmount = $money;
        $this->lastRefillDate   = Carbon::now();
    }

    /**
     * @param Subscription $subscription
     *
     * @return bool
     */
    public function equals(Subscription $subscription = null)
    {
        if (!$subscription) {
            return false;
        }

        return json_encode($this) == json_encode($subscription);
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'created_at'                 => $this->getCreatedAt(),
            'updated_at'                 => $this->getUpdatedAt(),
            'expiration_date'            => $this->getExpirationDate(),
            'last_refill_date'           => $this->getLastRefillDate(),
            'last_refill_amount'         => $this->getLastRefillAmount(),
            'pin'                        => $this->getPin(),
            'subscription_creation_date' => $this->getSubscriptionCreationDate(),
        ];
    }
}
