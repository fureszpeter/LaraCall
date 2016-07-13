<?php
namespace LaraCall\Domain\Entities;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\Column(type="datetime", name="range_from", nullable=false)
     */
    protected $rangeFrom;

    /**
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime", name="range_to", nullable=false)
     */
    protected $rangeTo;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=254, nullable=false)
     */
    protected $command;

    /**
     * @var ArrayCollection|EbayTransactionLog[]
     *
     * @ORM\OneToMany(targetEntity="EbayTransactionLog", mappedBy="cronLog")
     */
    protected $transactions = [];

    /**
     * @param PastDateRange        $dateRange
     * @param string               $command
     */
    public function __construct(PastDateRange $dateRange, $command)
    {
        parent::__construct();
        TypeChecker::assertString($command, '$command');

        $this->rangeFrom    = $dateRange->getDateFrom();
        $this->rangeTo      = $dateRange->getDateTo();
        $this->command      = $command;
        $this->transactions = new ArrayCollection();
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

    /**
     * @return ArrayCollection|EbayTransactionLog[]
     */
    public function getTransactions()
    {
        return $this->transactions;
    }
}
