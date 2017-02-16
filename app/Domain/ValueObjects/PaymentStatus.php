<?php
namespace LaraCall\Domain\ValueObjects;

use UnexpectedValueException;

class PaymentStatus
{
    const STATUS_COMPLETED       = 'completed';
    const STATUS_PENDING         = 'pending';
    const STATUS_CANCEL_REVERSED = 'cancel_reversed';
    const STATUS_REVERSED        = 'reversed';
    const STATUS_REFUNDED        = 'refunded';
    const STATUS_FAILED          = 'failed';

    const VALID_STATUSES = [
        self::STATUS_COMPLETED,
        self::STATUS_PENDING,
        self::STATUS_CANCEL_REVERSED,
        self::STATUS_REVERSED,
        self::STATUS_REFUNDED,
        self::STATUS_FAILED,
    ];

    /**
     * @var string
     */
    private $status;

    /**
     * @param string $status
     */
    public function __construct(string $status)
    {
        if ( ! in_array($status, self::VALID_STATUSES)) {
            throw new UnexpectedValueException(
                sprintf(
                    'Invalid status. [received: %s, valid statuses: %s]',
                    $status,
                    implode(', ', self::VALID_STATUSES)
                )
            );
        }
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getStatus();
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}
