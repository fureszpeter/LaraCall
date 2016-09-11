<?php
namespace LaraCall\Domain\ValueObjects\eBay;

use DateTime;
use DateTimeInterface;
use DateTimeZone;
use TestCase;

class EbayTimeTest extends TestCase
{

    /**
     * @dataProvider validDateStringProvider
     *
     * @param string            $dateString
     * @param DateTimeInterface $expectedDate
     */
    public function test_parse_string($dateString, DateTimeInterface $expectedDate)
    {
        $ebayTime = EbayTime::parseString($dateString);

        $this->assertEquals($expectedDate, $ebayTime);
    }

    public function test_to_string()
    {
        $date = new EbayTime('2004-08-04T19:09:02.768Z');

        $this->assertEquals('2004-08-04T19:09:02.768Z', $date->__toString());
    }

    /**
     * @return array
     */
    public function validDateStringProvider()
    {
        return [
            ['2016-01-01T00:00:00.000Z', DateTime::createFromFormat('Y-m-d H:i:s', '2016-01-01 00:00:00', new DateTimeZone('Z'))],
        ];
    }
}

