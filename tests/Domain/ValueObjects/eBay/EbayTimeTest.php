<?php
namespace LaraCall\Domain\ValueObjects\eBay;

use TestCase;

class EbayTimeTest extends TestCase
{

    public function test_to_string()
    {
        $date = new EbayTime('2004-08-04T19:09:02.768Z');

        $this->assertEquals('2004-08-04T19:09:02.768Z', $date->__toString());
    }
}

