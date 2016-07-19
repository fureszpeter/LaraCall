<?php
namespace LaraCall\Domain\ValueObjects;

use DateTimeInterface;

class DateTime extends \DateTime
{
    public function format($format = null)
    {
        if (is_null($format)) {
            $format = 'Y-m-d H:i:s';
        }

        return parent::format($format);
    }

    public function __toString()
    {
        return $this->format();
    }

    /**
     * @param DateTimeInterface $dt
     *
     * @return static
     */
    public static function instance(DateTimeInterface $dt)
    {
        return new static($dt->format('Y-m-d H:i:s'), $dt->getTimezone());
    }
}
