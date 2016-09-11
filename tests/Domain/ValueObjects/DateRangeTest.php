<?php
namespace LaraCall\Domain\ValueObjects;

use Carbon\Carbon;
use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;
use TestCase;
use UnexpectedValueException;

/**
 * Class DateRangeTest.
 *
 * @package LaraCall
 *
 * @license Proprietary
 */
class DateRangeTest extends TestCase
{
    /**
     * @dataProvider validDateRangeProvider
     *
     * @param DateTimeInterface $from
     * @param DateTimeInterface $to
     */
    public function testCanCreateValidDate(DateTimeInterface $from, DateTimeInterface $to)
    {
        new DateRange(
            DateTimeImmutable::createFromMutable($from),
            DateTimeImmutable::createFromMutable($to)
        );
    }

    /**
     * @expectedException UnexpectedValueException
     */
    public function testThrowExceptionOnInvalidDateRange()
    {
        new DateRange(
            DateTimeImmutable::createFromMutable(Carbon::now()),
            DateTimeImmutable::createFromMutable(Carbon::now()->subDay(1))
        );
    }

    public function testCanBeTheSameDate()
    {
        $now = DateTimeImmutable::createFromMutable(Carbon::now());

        new DateRange($now, $now);
    }

    /**
     * @return array
     */
    public function validDateRangeProvider()
    {
        return [
            [Carbon::now()->subDay(10), Carbon::now()->subDay(1)],
            //Can be a future day
            [Carbon::now(), Carbon::now()->addDay(10)],
        ];
    }

    /**
     * @dataProvider rangeProvider
     *
     * @param DateRange    $dateRange
     * @param DateInterval $expectedInterval
     * @param int          $days
     */
    public function test_getInterval_returns_right_value(
        DateRange $dateRange,
        DateInterval $expectedInterval,
        $days
    ) {
        $interval = $dateRange->getInterval();
        $this->assertEquals($days, $interval->days);
        $this->assertAttributeEquals($expectedInterval->y, 'y', $interval);
        $this->assertAttributeEquals($expectedInterval->m, 'm', $interval);
        $this->assertAttributeEquals($expectedInterval->d, 'd', $interval);
        $this->assertAttributeEquals($expectedInterval->h, 'h', $interval);
        $this->assertAttributeEquals($expectedInterval->i, 'i', $interval);
        $this->assertAttributeEquals($expectedInterval->s, 's', $interval);
        $this->assertAttributeEquals($expectedInterval->invert, 'invert', $interval);
    }

    /**
     * @return array
     */
    public function rangeProvider()
    {
        return [
            [
                new DateRange(
                    DateTimeImmutable::createFromFormat('Y-m-d', '2016-01-01'),
                    DateTimeImmutable::createFromFormat('Y-m-d', '2016-02-02')
                ),
                new DateInterval('P1M1D'),
                32
            ],
            [
                new DateRange(
                    DateTimeImmutable::createFromFormat('Y-m-d', '2015-01-01'),
                    DateTimeImmutable::createFromFormat('Y-m-d', '2016-01-01')
                ),
                new DateInterval('P1Y'),
                365
            ],
            [
                new DateRange(
                    DateTimeImmutable::createFromFormat('Y-m-d', '2016-01-01'),
                    DateTimeImmutable::createFromFormat('Y-m-d', '2017-01-01')
                ),
                new DateInterval('P1Y'),
                366 //leap year
            ],
        ];
    }
}
