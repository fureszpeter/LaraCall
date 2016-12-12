<?php
namespace LaraCall\Domain\ValueObjects\eBay;

use Furesz\TypeChecker\TypeChecker;
use JsonSerializable;

/**
 * Class EbaySiteVO.
 *
 * @package LaraCall
 *
 * @license Proprietary
 */
class EbaySiteVO implements JsonSerializable
{
    const ALLOWED_CODES = [
        'US',
        'IT',
    ];

    /**
     * @var string
     */
    private $countryCode;

    /**
     * @param string $countryCode
     */
    public function __construct($countryCode)
    {
        TypeChecker::assertString($countryCode, '$countryCode');

        if ( ! in_array($countryCode, self::ALLOWED_CODES)) {
            throw new \UnexpectedValueException(
                sprintf(
                    'This country code is not allowed or invalid. [code: %s, allowed: %s]',
                    $countryCode,
                    implode(', ', self::ALLOWED_CODES)
                )
            );
        }

        $this->countryCode = $countryCode;
    }

    public function __toString()
    {
        return $this->getCountryCode();
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @return string
     */
    function jsonSerialize()
    {
        return $this->getCountryCode();
    }
}
