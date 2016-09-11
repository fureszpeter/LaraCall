<?php
namespace LaraCall\Domain\ValueObjects;

use DateInterval;
use DateTimeImmutable;
use TestCase;

/**
 * Class DateSplitterTest.
 *
 * @package LaraCall
 *
 * @license Proprietary
 */
class DateSplitterTest extends TestCase
{
    public function test_return_original_if_interval_bigger_than_range()
    {
        $dateFrom  = DateTimeImmutable::createFromFormat('Y-m-d', '2016-01-01');
        $dateTo    = DateTimeImmutable::createFromFormat('Y-m-d', '2016-02-01');
        $dateRange = new DateRange($dateFrom, $dateTo);

        //Interval is two months
        $interval     = new DateInterval('P2M');
        $dateSplitter = new DateSplitter($dateRange);

        $dateRanges = $dateSplitter->split($interval);

        $this->assertCount(1, $dateRanges);
        $this->assertContainsOnlyInstancesOf(DateRange::class, $dateRanges);
        $this->assertEquals($dateRange, current($dateRanges));
    }

    /**
     * @dataProvider validRangeProvider
     *
     * @param DateRange    $dateRange
     * @param DateInterval $interval
     * @param DateRange[]  $expectedRanges
     */
    public function test_return_correct_ranges_if_interval_smaller_than_range(
        DateRange $dateRange,
        DateInterval $interval,
        DateRange ...$expectedRanges
    ) {
        $dateSplitter = new DateSplitter($dateRange);

        $ranges = $dateSplitter->split($interval);

        $this->assertEquals($expectedRanges, $ranges);
    }

    /**
     * @return array
     */
    public function validRangeProvider()
    {
        $dateFrom  = DateTimeImmutable::createFromFormat('Y-m-d', '2016-01-01');
        $dateTo    = DateTimeImmutable::createFromFormat('Y-m-d', '2016-02-01');
        $dateRange = new DateRange($dateFrom, $dateTo);

        return [
            [
                $dateRange,
                new DateInterval('P10D'),
                new DateRange(
                    DateTimeImmutable::createFromFormat('Y-m-d', '2016-01-01'),
                    DateTimeImmutable::createFromFormat('Y-m-d', '2016-01-11')
                ),
                new DateRange(
                    DateTimeImmutable::createFromFormat('Y-m-d', '2016-01-11'),
                    DateTimeImmutable::createFromFormat('Y-m-d', '2016-01-21')
                ),
                new DateRange(
                    DateTimeImmutable::createFromFormat('Y-m-d', '2016-01-21'),
                    DateTimeImmutable::createFromFormat('Y-m-d', '2016-01-31')
                ),
                new DateRange(
                    DateTimeImmutable::createFromFormat('Y-m-d', '2016-01-31'),
                    DateTimeImmutable::createFromFormat('Y-m-d', '2016-02-01')
                ),
            ],
//            [
//                new DateRange(
//                    DateTimeImmutable::createFromMutable(EbayTime::parseString('2016-01-01T00:00:00.000Z')),
//                    DateTimeImmutable::createFromMutable(EbayTime::parseString('2016-09-11T22:03:01.000Z'))
//                ),
//                new DateInterval('P90D'),
//                new DateRange(
//                    DateTimeImmutable::createFromFormat('Y-m-d', '2016-01-01'),
//                    DateTimeImmutable::createFromFormat('Y-m-d', '2016-01-01')->add(new DateInterval('P90D'))
//                ),
//            ]
        ];
    }
}

