<?php
namespace LaraCall\Domain\Entities;

use Carbon\Carbon;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use JsonSerializable;
use LaraCall\Domain\Collections\PinCollection;
use LaraCall\Domain\ValueObjects\Password;
use LaraCall\Domain\ValueObjects\Pin;
use LaraCall\Domain\ValueObjects\UserContactDetails;
use OutOfBoundsException;
use ValueObjects\Web\EmailAddress;

/**
 * Class User.
 *
 * @package LaraCall
 *
 * @license Proprietary
 *
 * @ORM\Entity(repositoryClass="\LaraCall\Infrastructure\Repositories\DoctrineUserRepository")
 */
class User extends AbstractEntity implements JsonSerializable
{
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=128, unique=true, nullable=false)
     */
    protected $email;

    /**
     * @var UserContactDetails
     *
     * @ORM\Embedded(class="\LaraCall\Domain\ValueObjects\UserContactDetails")
     */
    protected $contact;

    /**
     * @var string|null
     *
     * @ORM\Column(name="password", type="string", length=128, nullable=true)
     */
    protected $password;

    /**
     * @var DateTimeInterface
     *
     * @ORM\Column(name="registration_date", type="datetime", nullable=false)
     */
    protected $registrationDate;

    /**
     * @var Subscription|null
     *
     * @ORM\OneToOne(targetEntity="Subscription", mappedBy="user", cascade={"ALL"}, cascade={"all"})
     */
    protected $subscription;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false, options={"default"=0})
     */
    protected $subscriptionCounter = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="pins", type="text")
     */
    protected $pins;

    /**
     * @param EmailAddress      $email
     * @param DateTimeInterface $registrationDate
     *
     * @throws InvalidArgumentException If Registration date is a future date.
     */
    public function __construct(EmailAddress $email, DateTimeInterface $registrationDate = null)
    {
        parent::__construct();

        $this->email = (string) $email;

        $this->pins  = json_encode(new PinCollection());
    }

    /**
     * @return UserContactDetails
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param UserContactDetails $contact
     *
     * @return $this
     */
    public function setContact(UserContactDetails $contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    /**
     * @param DateTimeInterface $registrationDate
     *
     * @throws InvalidArgumentException If registration date is a future date.
     *
     * @return $this
     */
    public function setRegistrationDate(DateTimeInterface $registrationDate)
    {
        if ($registrationDate && Carbon::instance($registrationDate)->gt(Carbon::now())) {
            throw new InvalidArgumentException('Future date not allowed for registration');
        } elseif ($registrationDate) {
            $this->registrationDate = $registrationDate;
        } elseif (is_null($registrationDate)) {
            $this->registrationDate = Carbon::now();
        }

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'email'                => (string) $this->getEmail(),
            'password'             => $this->getPassword(),
            'subscription'         => $this->getSubscription(),
            'pins'                 => $this->getPins(),
            'subscription_counter' => $this->getSubscriptionCounter(),
        ];
    }

    /**
     * @return EmailAddress
     */
    public function getEmail()
    {
        return new EmailAddress($this->email);
    }

    /**
     * @param EmailAddress $email
     *
     * @return User
     */
    public function setEmail(EmailAddress $email)
    {
        $this->email = (string) $email;

        return $this;
    }

    /**
     * @return Password|null
     */
    public function getPassword()
    {
        return $this->password ? new Password($this->password) : null;
    }

    /**
     * @param Password|null $password
     *
     * @return User
     */
    public function setPassword(Password $password)
    {
        $this->password = (string) $password;

        return $this;
    }

    /**
     * @throws OutOfBoundsException If no subscription available.
     *
     * @return Subscription|null
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * @param Subscription $subscription
     *
     * @return User
     */
    public function setSubscription(Subscription $subscription)
    {
        $this->subscription = $subscription;
        $this->addPin($subscription->getPin());

        return $this;
    }

    /**
     * @return User
     */
    public function resetSubscriptionsAndPins()
    {
        $this->subscription        = null;
        $this->subscriptionCounter = 0;
        $this->pins                = json_encode(new PinCollection());

        return $this;
    }

    /**
     * @return $this
     */
    public function resetPins()
    {
        $this->pins                = json_encode(new PinCollection());
        $this->subscriptionCounter = 0;

        return $this;
    }

    /**
     * @return PinCollection
     */
    public function getPins()
    {
        $collection = new PinCollection();

        return ($this->pins) ? $collection->fromJson($this->pins) : $collection;
    }

    /**
     * @return int
     */
    public function getSubscriptionCounter()
    {
        return $this->subscriptionCounter;
    }

    /**
     * @param \LaraCall\Domain\ValueObjects\Pin[] $pins
     *
     * @return User
     */
    protected function addPin(Pin ...$pins)
    {
        $collection = $this->getPins();

        foreach ($pins as $pin) {
            $collection->add($pin);
            $this->subscriptionCounter++;
        }

        $this->pins = json_encode($collection);

        return $this;
    }
}
