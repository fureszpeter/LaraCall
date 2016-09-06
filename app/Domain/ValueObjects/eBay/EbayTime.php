<?php
namespace LaraCall\Domain\ValueObjects\eBay;

use DateTime;

class EbayTime extends DateTime
{
    function __toString()
    {
        return $this->format('Y-m-d\TH:i:s.Z\Z');
    }

}
