<?php
namespace LaraCall\Domain\Entities;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class EbayUserEntity.
 *
 * @package LaraCall
 *
 * @license Proprietary
 *
 * @ORM\Entity(repositoryClass="LaraCall\Infrastructure\Repositories\DoctrineEbayUserRepository")
 */
class EbayUser extends AbstractEntityWithId
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64, nullable=false, unique=true)
     */
    protected $ebayUserTokenId;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64, nullable=false, unique=true)
     */
    protected $ebayUserId;

    /**
     * @var string
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    protected $email;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetimetz", nullable=true)
     */
    protected $dateLastPurchase;

    /**
     * @var Subscription
     *
     * @ORM\ManyToOne(targetEntity="Subscription", inversedBy="ebayUsers")
     * @ORM\JoinColumn(nullable=true, name="subscription_id", referencedColumnName="id")
     */
    protected $subscription;


    /**
     * @param string            $ebayUserTokenId
     * @param string            $ebayUserId
     * @param string            $email
     * @param DateTimeInterface $dateLastPurchase
     */
    public function __construct(
        string $ebayUserTokenId,
        string $ebayUserId,
        string $email,
        DateTimeInterface $dateLastPurchase
    ) {
        parent::__construct();

        $this->ebayUserTokenId  = $ebayUserTokenId;
        $this->ebayUserId       = $ebayUserId;
        $this->email            = $email;
        $this->dateLastPurchase = $dateLastPurchase;
    }

    /**
     * @return Subscription|null
     */
    public function getSubscription():? Subscription
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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEbayUserTokenId(): string
    {
        return $this->ebayUserTokenId;
    }

    /**
     * @return string
     */
    public function getEbayUserId(): string
    {
        return $this->ebayUserId;
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
    public function getDateLastPurchase(): DateTime
    {
        return $this->dateLastPurchase;
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
     * @return string
     */
    public function __toString()
    {
        return $this->getEbayUserId();
    }
}
