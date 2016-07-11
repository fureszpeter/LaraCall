<?php
namespace LaraCall\Domain\ValueObjects;

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
     * @var DateTimeInterface
     */
    private $dateFrom;

    /**
     * @var DateTimeInterface
     */
    private $dateTo;

    /**
     * @param DateTimeInterface $dateFrom
     * @param DateTimeInterface $dateTo
     *
     * @throws UnexpectedValueException If dateFrom later than dateTo.
     */
    public function __construct(DateTimeInterface $dateFrom, DateTimeInterface $dateTo)
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

        $this->dateFrom = clone $dateFrom;
        $this->dateTo = clone $dateTo;
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
}
