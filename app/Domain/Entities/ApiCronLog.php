<?php
namespace LaraCall\Domain\Entities;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Furesz\TypeChecker\TypeChecker;
use LaraCall\Domain\ValueObjects\PastDateRange;

/**
 * Class ApiCronLog.
 *
 * @package LaraCall
 *
 * @license Proprietary
 *
 * @ORM\Entity()
 */
class ApiCronLog extends AbstractEntity
{
    /**
     * @var DateTimeInterface
     *
     * @ORM\Column(name="range_from", nullable=false)
     */
    protected $rangeFrom;

    /**
     * @var DateTimeInterface
     *
     * @ORM\Column(name="range_to", nullable=false)
     */
    protected $rangeTo;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=254, nullable=false)
     */
    private $command;

    /**
     * @param PastDateRange $dateRange
     * @param string        $command
     *
     *
     */
    public function __construct(PastDateRange $dateRange, $command)
    {
        TypeChecker::assertString($command, '$command');

        parent::__construct();
        $this->rangeFrom = $dateRange->getDateFrom();
        $this->rangeTo = $dateRange->getDateTo();
        $this->command = $command;
    }

    /**
     * @return DateTimeInterface
     */
    public function getRangeFrom()
    {
        return $this->rangeFrom;
    }

    /**
     * @return DateTimeInterface
     */
    public function getRangeTo()
    {
        return $this->rangeTo;
    }

    /**
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }
}
