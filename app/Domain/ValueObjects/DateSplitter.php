<?php
namespace LaraCall\Domain\ValueObjects;

use DateInterval;
use DateTimeImmutable;

class DateSplitter
{
    /**
     * @var DateRange
     */
    private $dateRange;

    /**
     * @param DateRange $dateRange
     */
    public function __construct(DateRange $dateRange)
    {
        $this->dateRange = clone $dateRange;
    }

    /**
     * @param DateInterval $maxInterval
     *
     * @return DateRange[]
     */
    public function split(DateInterval $maxInterval)
    {
        $baseDate = new DateTimeImmutable();
        $ranges = [];

        if ($baseDate->add($this->dateRange->getInterval()) < $baseDate->add($maxInterval)) {
            $ranges[] = $this->dateRange;
            return $ranges;
        }

        $startDate = $this->dateRange->getDateFrom();
        $endDate = $this->dateRange->getDateFrom()->add($maxInterval);

        do{
            $actualRange = new DateRange(
                $startDate,
                $endDate
            );
            $ranges[] = $actualRange;

            $startDate = $startDate->add($maxInterval);
            $endDate = $endDate->add($maxInterval);

            if ($endDate > $this->dateRange->getDateTo()) {
                $endDate = $this->dateRange->getDateTo();
            }

        }while($endDate != $this->dateRange->getDateTo());

        $actualRange = new DateRange(
            $startDate,
            $endDate
        );
        $ranges[] = $actualRange;

        return $ranges;
    }
}
