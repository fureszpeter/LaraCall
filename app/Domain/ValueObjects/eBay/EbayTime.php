<?php
namespace LaraCall\Domain\ValueObjects\eBay;

use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use Furesz\TypeChecker\TypeChecker;

class EbayTime extends DateTimeImmutable
{
    /**
     * @param string $dateString
     *
     * @return DateTime
     *
     * @throws \InvalidArgumentException If $dateString is not a string.
     */
    public static function parseString($dateString)
    {
        TypeChecker::assertString($dateString, '$dateString');

        return parent::createFromFormat('Y-m-d\TH:i:s.u\Z', $dateString, new DateTimeZone('Z'));
    }

    /**
     * @return string
     */
    function __toString()
    {
        return (string)preg_replace('/000Z$/', 'Z', $this->format('Y-m-d\TH:i:s.u\Z'));
    }

}
