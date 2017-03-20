<?php
namespace LaraCall\Domain\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use LaraCall\Domain\ValueObjects\DeliveryToken;
use LaraCall\Events\DeliveryEntityCreatedEvent;

/**
 * Class DeliveryEntity.
 *
 * @package LaraCall
 *
 * @license Proprietary
 *
 * @ORM\Entity(repositoryClass="LaraCall\Infrastructure\Repositories\DoctrineDeliveryTokenRepository")
 *
 * @ORM\HasLifecycleCallbacks()
 */
class PinTokenDelivery extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="string", length=25, nullable=false, unique=true)
     */
    protected $token;

    /**
     * @var Pin
     *
     * @ORM\ManyToOne(targetEntity="Pin", inversedBy="pinTokenDelivery")
     * @ORM\JoinColumn(name="pin", referencedColumnName="pin", nullable=false)
     */
    protected $pin;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetimetz", nullable=false)
     */
    protected $dateExpire;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $displayCounter = 0;

    /**
     * @param DeliveryToken $token
     * @param Pin           $pin
     */
    public function __construct(DeliveryToken $token, Pin $pin)
    {
        parent::__construct();

        $this->token      = $token->getToken();
        $this->pin        = $pin;
        $this->dateExpire = new DateTime('now + 3 days');
    }

    /**
     * @return DeliveryToken
     */
    public function getToken(): DeliveryToken
    {
        return new DeliveryToken($this->token);
    }

    /**
     * @return Pin
     */
    public function getPin(): Pin
    {
        return $this->pin;
    }

    /**
     * @return DateTime
     */
    public function getDateExpire(): DateTime
    {
        return $this->dateExpire;
    }

    /**
     * @return int
     */
    public function getDisplayCounter(): int
    {
        return $this->displayCounter;
    }

    /**
     * @ORM\PostPersist()
     */
    public function postPersist()
    {
        event(new DeliveryEntityCreatedEvent($this->getToken()));
    }
}
