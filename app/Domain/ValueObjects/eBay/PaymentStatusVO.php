<?php
namespace LaraCall\Domain\ValueObjects\eBay;

use DTS\eBaySDK\Trading\Enums\PaymentStatusCodeType;
use Furesz\TypeChecker\TypeChecker;
use JsonSerializable;
use UnexpectedValueException;

class PaymentStatusVO implements JsonSerializable
{
    const STATUSES = [
        PaymentStatusCodeType::C_NO_PAYMENT_FAILURE,
        PaymentStatusCodeType::C_PAY_PAL_PAYMENT_IN_PROCESS,
        PaymentStatusCodeType::C_BUYER_CREDIT_CARD_FAILED,
        PaymentStatusCodeType::C_BUYER_FAILED_PAYMENT_REPORTED_BY_SELLER,
        PaymentStatusCodeType::C_PAYMENT_IN_PROCESS,
        PaymentStatusCodeType::C_BUYERE_CHECK_BOUNCED,
    ];

    private $status;

    /**
     * @param string $status
     */
    public function __construct($status)
    {
        TypeChecker::assertString($status, '$status');

        if ( ! in_array($status, self::STATUSES)) {
            throw new UnexpectedValueException(
                sprintf(
                    'Not allowed payment status. [status: %s, allowed: %s]',
                    $status,
                    implode(', ', self::STATUSES)
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

    /**
     * @return string
     */
    function jsonSerialize()
    {
        return $this->getStatus();
    }
}
