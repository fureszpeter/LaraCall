<?php
namespace LaraCall\Domain\ValueObjects;

use Furesz\TypeChecker\TypeChecker;
use UnexpectedValueException;

/**
 * Class OrderStatusVO.
 *
 * @method static OrderStatusVO STATUS_RECEIVED()
 * @method static OrderStatusVO STATUS_PROCESSING()
 * @method static OrderStatusVO STATUS_WAIT_FOR_PAYMENT()
 * @method static OrderStatusVO STATUS_HUMAN_REVIEW()
 * @method static OrderStatusVO STATUS_PAYED()
 * @method static OrderStatusVO STATUS_SHIPPED()
 * @method static OrderStatusVO STATUS_RETURNED()
 *
 * @package LaraCall\Domain\ValueObjects
 */
class OrderStatusVO
{
    const STATUS_RECEIVED          = 'received';
    const STATUS_PROCESSING        = 'processing';
    const STATUS_WAIT_FOR_PAYMENT  = 'wait_for_payment';
    const STATUS_HUMAN_REVIEW      = 'human_review';
    const STATUS_PAYED             = 'payed';
    const STATUS_SHIPPED           = 'shipped';
    const STATUS_RETURNED          = 'returned';

    const ALLOWED_STATUSES = [
        self::STATUS_RECEIVED,
        self::STATUS_PROCESSING,
        self::STATUS_WAIT_FOR_PAYMENT,
        self::STATUS_HUMAN_REVIEW,
        self::STATUS_PAYED,
        self::STATUS_SHIPPED,
        self::STATUS_RETURNED,
    ];

    /**
     * @var string
     */
    protected $status;

    /**
     * @param string $status
     *
     * @throws \InvalidArgumentException If status is not a string.
     * @throws UnexpectedValueException If value is not allowed or invalid.
     */
    public function __construct($status)
    {
        TypeChecker::assertString($status, '$status');

        if (! in_array($status, self::ALLOWED_STATUSES)) {
            throw new UnexpectedValueException(
                sprintf(
                    'Invalid status. [status: %s, allowed: %s]',
                    $status,
                    implode(', ', self::ALLOWED_STATUSES)
                )
            );
        }

        $this->status = $status;
    }

    /**
     * @param string $name
     * @param array $arguments
     *
     * @return $this
     */
    public static function __callStatic($name, $arguments = [])
    {
        return new static(constant('self::' . $name));
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getStatus();
    }
}
