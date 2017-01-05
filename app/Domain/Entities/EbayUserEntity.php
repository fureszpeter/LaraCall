<?php
namespace LaraCall\Domain\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class EbayUserEntity.
 *
 * @package LaraCall
 *
 * @license Proprietary
 *
 * @ORM\Entity()
 */
class EbayUserEntity
{
    /**
     * @var string
     *
     * @ORM\Id()
     * @ORM\Column(type="string", length=64, nullable=false)
     */
    protected $ebayId;

    /**
     * @var UserEntity
     * @ORM\OneToOne(targetEntity="UserEntity", mappedBy="ebayUser")
     */
    protected $user;

    /**
     * @var string
     * @ORM\Column(type="string", length=64, nullable=false)
     */
    protected $username;

    /**
     * @var string
     * @ORM\Column(type="string", length=64, nullable=false)
     */
    protected $email;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetimetz", nullable=false)
     */
    protected $dateCreated;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetimetz", nullable=false)
     */
    protected $dateUpdated;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetimetz", nullable=true)
     */
    protected $dateLastPurchase;
}
