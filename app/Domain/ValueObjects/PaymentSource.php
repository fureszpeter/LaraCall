<?php
namespace LaraCall\Domain\ValueObjects;

use UnexpectedValueException;

/**
 * Class PaymentSource.
 *
 * @package LaraCall
 *
 * @license Proprietary
 */
class PaymentSource
{
    const SOURCE_EBAY   = 'ebay';
    const SOURCE_PAYPAL = 'paypal';

    const ALLOWED_SOURCES = [
        self::SOURCE_EBAY,
        self::SOURCE_PAYPAL,
    ];

    /**
     * @var string
     */
    private $source;

    /**
     * @param string $source
     */
    public function __construct(string $source)
    {
        if ( ! in_array($source, self::ALLOWED_SOURCES)) {
            throw new UnexpectedValueException(
                sprintf(
                    sprintf(
                        'Invalid payment source. [source: %s, allowed: %s]',
                        $source,
                        implode(',', self::ALLOWED_SOURCES)
                    )
                )
            );
        }

        $this->source = $source;
    }

    /**
     * @return bool
     */
    public function isEbay(): bool
    {
        return $this->getSource() == self::SOURCE_EBAY;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    public function __toString()
    {
        return $this->getSource();
    }
}
