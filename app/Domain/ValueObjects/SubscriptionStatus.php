<?php
namespace LaraCall\Domain\ValueObjects;

use UnexpectedValueException;

class SubscriptionStatus
{
    const CANCELLED                    = 0;
    const ACTIVE                       = 1;
    const NEW                          = 2;
    const WAITING_MAIL_CONFIRMATION    = 3;
    const RESERVED                     = 4;
    const EXPIRED                      = 5;
    const SUSPEND_FOR_UNDERPAYMENT     = 6;
    const SUSPEND_FOR_LITIGATION       = 7;
    const WAITING_SUBSCRIPTION_PAYMENT = 8;

    const ALLOWED_TYPES = [
        self::CANCELLED                    => 'CANCELLED',
        self::ACTIVE                       => 'ACTIVE',
        self::NEW                          => 'NEW',
        self::WAITING_MAIL_CONFIRMATION    => 'WAITING_MAIL_CONFIRMATION',
        self::RESERVED                     => 'RESERVED',
        self::EXPIRED                      => 'EXPIRED',
        self::SUSPEND_FOR_UNDERPAYMENT     => 'SUSPEND_FOR_UNDERPAYMENT',
        self::SUSPEND_FOR_LITIGATION       => 'SUSPEND_FOR_LITIGATION',
        self::WAITING_SUBSCRIPTION_PAYMENT => 'WAITING_SUBSCRIPTION_PAYMENT',
    ];

    /**
     * @var int
     */
    private $status;

    /**
     * @param int $status
     */
    public function __construct(int $status)
    {
        if ( ! in_array($status, array_keys(self::ALLOWED_TYPES))) {
            throw new UnexpectedValueException('invalid status.');
        }

        $this->status = $status;
    }

    public function __toString()
    {
        return $this->getStatusName();
    }

    public function getStatusName(): string
    {
        return self::ALLOWED_TYPES[$this->getStatus()];
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    public function isBlocked(): bool
    {
        return in_array($this->getStatus(), [
            self::CANCELLED,
            self::SUSPEND_FOR_LITIGATION,
            self::SUSPEND_FOR_UNDERPAYMENT,
        ]);
    }
}
