<?php
namespace LaraCall\Domain\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class EbayUser.
 *
 * @package LaraCall
 *
 * @license Proprietary
 *
 * @ORM\Entity()
 */
class EbayUser extends AbstractEntity
{

    /**
     */
    public function __construct($username, $firstName, $lastName, $site, $email, )
    {
    }
}
