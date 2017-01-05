<?php
namespace LaraCall\Domain\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserEntity.
 *
 * @package LaraCall
 *
 * @license Proprietary
 *
 * @ORM\Entity(repositoryClass="")
 */
class UserEntity
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", unique=true, nullable=false)
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64, nullable=false)
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=254, nullable=false)
     */
    protected $password;

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

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64, nullable=true)
     * @ORM\OneToOne(targetEntity="EbayUserEntity", inversedBy="ebayId")
     * @ORM\JoinColumn(name="ebay_user_id", referencedColumnName="ebay_id")
     */
    protected $ebayUser;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @ORM\OneToMany(targetEntity="SubscriptionPinEntity", mappedBy="pin")
     */
    protected $pin;
}
