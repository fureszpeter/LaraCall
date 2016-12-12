<?php
namespace LaraCall\Domain\ValueObjects\eBay;

use Furesz\TypeChecker\TypeChecker;
use JsonSerializable;

/**
 * Class EbayItemVO.
 *
 * @package LaraCall
 *
 * @license Proprietary
 */
class EbayItemIdVO implements JsonSerializable
{
    /**
     * @var string
     */
    private $itemId;

    /**
     * @param string $itemId
     *
     * @throws \InvalidArgumentException If $itemId is not a string.
     * @throws \UnexpectedValueException If $itemId is not acceptable.
     */
    public function __construct($itemId)
    {
        TypeChecker::assertString($itemId, '$itemId');

        if ( ! preg_match('/^[0-9]{12}$/', $itemId)) {
            throw new \UnexpectedValueException(sprintf('Item id invalid. [itemId: %s]', $itemId));
        }

        $this->itemId = $itemId;
    }

    /**
     * @return string
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    public function __toString()
    {
        return $this->getItemId();
    }

    /**
     * @return string
     */
    function jsonSerialize()
    {
        return $this->getItemId();
    }
}
