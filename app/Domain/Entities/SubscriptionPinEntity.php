<?php
namespace LaraCall\Domain\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class SubscriptionPinEntity.
 *
 * @package LaraCall
 *
 * @license Proprietary
 *
 * @ORM\Entity()
 */
class SubscriptionPinEntity
{
    /**
     * @var string
     *
     * @ORM\Id()
     * @ORM\Column(length=16, nullable=false, unique=true)
     */
    protected $pin;

    /**
     * @var UserEntity
     *
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="UserEntity", inversedBy="id")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="pin")
     */
    protected $user;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetimetz", nullable=false)
     */
    protected $dateCreated;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetimetz", nullable=false)
     */
    protected $dateUpdated;
}
