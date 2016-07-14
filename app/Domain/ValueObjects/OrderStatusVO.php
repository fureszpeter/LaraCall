<?php


namespace LaraCall\Domain\ValueObjects;

use Furesz\TypeChecker\TypeChecker;
use UnexpectedValueException;

/**
 * Class OrderStatusVO
 *
 * @package LaraCall\Domain\ValueObjects
 */
class OrderStatusVO
{
    const STATUS_RECEIVED = 'received';
    const STATUS_PROCESSING = 'processing';
    const STATUS_WAIT_FOR_PAYMENT = 'processing';

    const ALLOWED_STATUSES = [
        self::STATUS_RECEIVED,
        self::STATUS_PROCESSING,
        self::STATUS_WAIT_FOR_PAYMENT,
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
