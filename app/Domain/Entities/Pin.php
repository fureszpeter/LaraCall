<?php
namespace LaraCall\Domain\Entities;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use LaraCall\Domain\Entities\Embeddables\BlockedEmbeddable;

/**
 * Class SubscriptionPinEntity.
 *
 * @package LaraCall
 *
 * @license Proprietary
 *
 * @ORM\Entity(repositoryClass="LaraCall\Infrastructure\Repositories\DoctrinePinRepository")
 */
class Pin extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="string", length=16, nullable=false, unique=true)
     */
    protected $pin;

    /**
     * @var BlockedEmbeddable
     *
     * @ORM\Embedded(class="LaraCall\Domain\Entities\Embeddables\BlockedEmbeddable")
     */
    protected $blocked;

    /**
     * @var Subscription
     *
     * @ORM\ManyToOne(targetEntity="Subscription", inversedBy="pins", cascade={"persist"})
     */
    protected $subscription;

    /**
     * @var Delivery
     *
     * @ORM\OneToMany(targetEntity="Delivery", mappedBy="pin")
     */
    protected $deliveryEntity;

    /**
     * @param string       $pin
     * @param Subscription $subscription
     */
    public function __construct(string $pin, Subscription $subscription)
    {
        parent::__construct();

        $this->pin          = $pin;
        $this->subscription = $subscription;
        $this->blocked      = new BlockedEmbeddable(false);
    }

    public function __toString()
    {
        return $this->getPin();
    }

    /**
     * @return string
     */
    public function getPin(): string
    {
        return $this->pin;
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
     * @return Subscription|null
     */
    public function getSubscription(): ?Subscription
    {
        return $this->subscription;
    }

    /**
     * @param Subscription $subscription
     *
     * @return $this
     */
    public function setSubscription($subscription)
    {
        $this->subscription = $subscription;

        return $this;
    }

    /**
     * @param DateTimeInterface $createdAt
     *
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
