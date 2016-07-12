<?php
namespace LaraCall\Domain\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use LaraCall\Domain\Entities\AbstractEntity;
use LaraCall\Domain\ValueObjects\eBay\OrderLineItemId;

/**
 * Class EbayOrder.
 *
 * @package LaraCall
 *
 * @license Proprietary
 *
 * @ORM\Entity()
 */
class EbayOrder extends AbstractEntity
{

    /**
     */
    public function __construct(
        OrderLineItemId $orderLineItemId,
    ) {
    }
}
