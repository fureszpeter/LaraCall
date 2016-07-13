<?php
namespace LaraCall\Domain\ValueObjects;

use Carbon\Carbon;
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
        new DateRange($from, $to);
    }

    /**
     * @expectedException UnexpectedValueException
     */
    public function testThrowExceptionOnInvalidDateRange()
    {
        new DateRange(Carbon::now(), Carbon::now()->subDay(1));
    }

    public function testCanBeTheSameDate()
    {
        $now = Carbon::now();

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
}
