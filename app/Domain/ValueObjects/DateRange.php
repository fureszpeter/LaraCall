<?php
namespace LaraCall\Domain\ValueObjects;

use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;
use UnexpectedValueException;

/**
 * Class DateRange.
 *
 * @package LaraCall
 *
 * @license Proprietary
 */
class DateRange
{
    /**
     * @var DateTimeImmutable
     */
    private $dateFrom;

    /**
     * @var DateTimeImmutable
     */
    private $dateTo;

    /**
     * @param DateTimeImmutable $dateFrom
     * @param DateTimeImmutable $dateTo
     *
     * @throws UnexpectedValueException If dateFrom later than dateTo.
     */
    public function __construct(DateTimeImmutable $dateFrom, DateTimeImmutable $dateTo)
    {
        if ($dateFrom > $dateTo) {
            throw new UnexpectedValueException(
                sprintf(
                    'dateFrom should earlier than dateTo. [from: %s, to: %s]',
                    $dateFrom->format(DATE_ISO8601),
                    $dateTo->format(DATE_ISO8601)
                )
            );
        }

        $this->dateFrom = $dateFrom;
        $this->dateTo   = $dateTo;
    }

    /**
     * @return DateTimeInterface
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * @return DateTimeInterface
     */
    public function getDateTo()
    {
        return $this->dateTo;
    }

    /**
     * @return DateInterval
     */
    public function getInterval()
    {
        return $this->getDateFrom()->diff($this->getDateTo());
    }
}
