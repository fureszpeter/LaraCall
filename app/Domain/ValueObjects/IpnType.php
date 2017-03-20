<?php
namespace LaraCall\Domain\ValueObjects;

use UnexpectedValueException;

class IpnType
{
    const TYPE_PAYPAL_EBAY  = 'paypal_ebay';
    const TYPE_PAYPAL_WEB   = 'paypal_web';
    const TYPE_PAYPAL_OTHER = 'paypal_other';

    const ALLOWED_TYPES = [
        self::TYPE_PAYPAL_EBAY,
        self::TYPE_PAYPAL_WEB,
    ];

    /**
     * @var string
     */
    private $type;

    /**
     * @param string $type
     *
     * @throws UnexpectedValueException If type is not allowed.
     */
    public function __construct(string $type)
    {
        if (!in_array($type, self::ALLOWED_TYPES)) {
            throw new UnexpectedValueException(
                sprintf('Unknown type. [received: %s, allowed: %s]', $type, implode(',', self::ALLOWED_TYPES))
            );
        }
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    public function __toString()
    {
        return $this->getType();
    }
}
