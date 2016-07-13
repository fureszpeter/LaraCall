<?php
namespace LaraCall\Domain\ValueObjects;

use DateTime;
use DateTimeInterface;
use UnexpectedValueException;

class PastDateRange extends DateRange
{
    /**
     * {@inheritdoc}
     *
     * @throws UnexpectedValueException If dateTo is a future date.
     */
    public function __construct(DateTimeInterface $dateFrom, DateTimeInterface $dateTo)
    {
        parent::__construct($dateFrom, $dateTo);

        if ($this->getDateTo() > new DateTime()) {
            throw new UnexpectedValueException(
                sprintf(
                    'DateTo can not be a future date. [to: %s]',
                    $dateTo->format(DATE_ISO8601)
                )
            );
        }
    }
}
