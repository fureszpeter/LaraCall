<?php
namespace LaraCall\Domain\ValueObjects;

use JsonSerializable;
use UnexpectedValueException;

class PaymentType implements JsonSerializable
{
    const TYPE_PAYPAL_EBAY = 'paypal_ebay';
    const TYPE_PAYPAL_WEB  = 'paypal_web';

    const ALLOWED_TYPES = [
        self::TYPE_PAYPAL_WEB,
        self::TYPE_PAYPAL_EBAY,
    ];

    /**
     * @var string
     */
    private $type;

    /**
     * @param string $type
     */
    public function __construct(string $type)
    {
        $this->assertValid($type);
        $this->type = $type;
    }

    /**
     * @param string $type
     *
     * @throws UnexpectedValueException If invalid type received.
     */
    private function assertValid(string $type)
    {
        if ( ! in_array($type, self::ALLOWED_TYPES)) {
            throw new UnexpectedValueException(
                sprintf(
                    'Invalid payment type. [received: %s, allowed: %s]',
                    $type,
                    implode(', ', self::ALLOWED_TYPES)
                )
            );
        }
    }

    public function __toString()
    {
        return $this->getType();
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->getType();
    }
}
