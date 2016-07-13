<?php
namespace LaraCall\Domain\ValueObjects\eBay;

use Furesz\TypeChecker\TypeChecker;
use UnexpectedValueException;

/**
 * Class OrderLineItemId.
 *
 * @package LaraCall
 *
 * @license Proprietary
 */
class OrderLineItemId
{
    /**
     * @var string
     */
    private $orderLineItemId;

    /**
     * @param string $orderLineItemId
     *
     * @throws \InvalidArgumentException If id is not a string.
     * @throws \UnexpectedValueException If id is not acceptable.
     */
    public function __construct($orderLineItemId)
    {
        TypeChecker::assertString($orderLineItemId, '$orderLineItemId');

        if (strlen($orderLineItemId) > 50) {
            throw new UnexpectedValueException(
                sprintf(
                    'OrderLineItemId max lenght is 50. [received: %s, id: %s]',
                    strlen($orderLineItemId),
                    $orderLineItemId
                )
            );
        }

        if (! preg_match('/^[0-9]{1,}\-[0-9]{1,}$/', $orderLineItemId)) {
            throw new UnexpectedValueException(
                sprintf(
                    'OrderLineItemId is invalid. [id: %s]',
                        $orderLineItemId
                )
            );
        }

        $this->orderLineItemId = $orderLineItemId;
    }

    /**
     * @return string
     */
    public function getOrderLineItemId()
    {
        return $this->orderLineItemId;
    }
}
