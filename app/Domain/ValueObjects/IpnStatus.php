<?php

namespace LaraCall\Domain\ValueObjects;

use UnexpectedValueException;

/**
 * Class IpnStatus.
 *
 * @package LaraCall
 *
 * @license Proprietary
 */
class IpnStatus
{
    const STATUS_UNPROCESSED = 'UNPROCESSED';
    const STATUS_PROCESSED   = 'PROCESSED';
    const STATUS_FAILED      = 'FAILED';

    const ALLOWED_STATUSES = [
        self::STATUS_UNPROCESSED,
        self::STATUS_PROCESSED,
        self::STATUS_FAILED,
    ];

    /**
     * @var string
     */
    private $status;

    /**
     * @param string $status
     *
     * @throws UnexpectedValueException
     */
    public function __construct(string $status)
    {
        if (!in_array($status, self::ALLOWED_STATUSES)) {
            throw new UnexpectedValueException(
                sprintf(
                    'Invalid status received. [allowed: %s, received: %s]',
                    implode(', ', self::ALLOWED_STATUSES),
                    $status
                )
            );
        }

        $this->status = $status;
    }

    public function __toString(): string
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

    /**
     * @return bool
     */
    public function isProcessed(): bool
    {
        return $this->getStatus() === self::STATUS_PROCESSED;
    }

    /**
     * @return bool
     */
    public function isUnprocessed(): bool
    {
        return $this->getStatus() === self::STATUS_UNPROCESSED;
    }

    /**
     * @return bool
     */
    public function isFailed(): bool
    {
        return $this->getStatus() === self::STATUS_FAILED;
    }
}
