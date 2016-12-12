<?php
namespace LaraCall\Domain\ValueObjects\eBay;

use DTS\eBaySDK\Trading\Enums\CompleteStatusCodeType;
use Furesz\TypeChecker\TypeChecker;
use JsonSerializable;
use UnexpectedValueException;

class CheckoutStatusVO implements JsonSerializable
{
    const TYPES = [
        CompleteStatusCodeType::C_COMPLETE,
        CompleteStatusCodeType::C_CUSTOM_CODE,
        CompleteStatusCodeType::C_INCOMPLETE,
        CompleteStatusCodeType::C_PENDING,
    ];

    /**
     * @var string
     */
    private $status;

    /**
     * @param string $status
     *
     * @throws \InvalidArgumentException If $status is not a string.
     * @throws UnexpectedValueException If $status is not acceptable.
     */
    public function __construct($status)
    {
        TypeChecker::assertString($status, '$status');

        if ( ! in_array($status, self::TYPES)) {
            throw new UnexpectedValueException(
                sprintf(
                    'Invalid checkout status code. [code: %s, allowed: %s]',
                    $status,
                    implode(',', self::TYPES)
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
    function jsonSerialize()
    {
        return $this->getStatus();
    }
}
