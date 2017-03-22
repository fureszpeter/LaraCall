<?php
namespace LaraCall\Domain\Entities;

use Carbon\Carbon;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use LaraCall\Domain\Entities\Embeddables\BlockedEmbeddable;

/**
 * Class UserEntity.
 *
 * @package LaraCall
 *
 * @license Proprietary
 *
 * @ORM\Entity(repositoryClass="LaraCall\Infrastructure\Repositories\DoctrineUserRepository")
 */
class User extends AbstractEntityWithId implements JsonSerializable
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64, nullable=false, unique=true)
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $token = null;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetimetz", nullable=true)
     */
    protected $tokenExpireDate = null;

    /**
     * @var BlockedEmbeddable
     *
     * @ORM\Embedded(class="LaraCall\Domain\Entities\Embeddables\BlockedEmbeddable")
     */
    protected $blocked;

    /**
     * @var Subscription|null
     *
     * @ORM\OneToOne(targetEntity="Subscription", mappedBy="user", cascade={"persist"})
     */
    protected $subscription;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetimetz", nullable=false)
     */
    protected $registrationDate;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $admin = false;

    /**
     * @param string $email
     * @param string $password
     */
    public function __construct(string $email, string $password)
    {
        parent::__construct();

        $this->registrationDate = new DateTime();
        $this->email            = $email;
        $this->password         = $password;
        $this->blocked          = new BlockedEmbeddable(false);
    }

    /**
     * @return Subscription|null
     */
    public function getSubscription(): ?Subscription
    {
        return $this->subscription;
    }

    /**
     * @param Subscription $subscription
     *
     * @return User
     */
    public function setSubscription(Subscription $subscription): self
    {
        $this->subscription = $subscription;

        return $this;
    }

    /**
     * @return bool
     */
    public function isBlocked(): bool
    {
        return $this->getBlocked()->getStatus();
    }

    /**
     * @return BlockedEmbeddable
     */
    public function getBlocked(): BlockedEmbeddable
    {
        return $this->blocked;
    }

    /**
     * @param BlockedEmbeddable $blocked
     *
     * @return $this
     */
    public function setBlocked(BlockedEmbeddable $blocked)
    {
        $this->blocked = $blocked;

        return $this;
    }

    /**
     * @param string $password
     *
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'email'            => $this->getEmail(),
            'registrationDate' => $this->getRegistrationDate()->format(DATE_ATOM),
            'blocked'          => $this->getBlocked(),
        ];
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return DateTime
     */
    public function getRegistrationDate(): DateTime
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(DateTimeInterface $dateTime)
    {
        $this->registrationDate = $dateTime;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->admin;
    }
}
