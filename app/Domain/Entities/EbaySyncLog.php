<?php
namespace LaraCall\Domain\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use LaraCall\Domain\ValueObjects\DateRange;

/**
 * Class EbaySyncLog.
 *
 * @package LaraCall
 *
 * @license Proprietary
 *
 * @ORM\Entity()
 */
class EbaySyncLog extends AbstractEntityWithId
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", name="range_from", nullable=false)
     */
    protected $rangeFrom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", name="range_to", nullable=false)
     */
    protected $rangeTo;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="result", nullable=false)
     */
    protected $result;

    /**
     * @var ArrayCollection|EbayTransactionLog[]
     *
     * @ORM\OneToMany(targetEntity="EbayTransactionLog", mappedBy="syncLog")
     */
    protected $transactionLogs;

    /**
     * @param DateRange $dateRange
     *
     */
    public function __construct(DateRange $dateRange)
    {
        parent::__construct();
        $this->rangeFrom = $dateRange->getDateFrom();
        $this->rangeTo   = $dateRange->getDateTo();
    }

    /**
     * @return \DateTime
     */
    public function getRangeFrom()
    {
        return $this->rangeFrom;
    }

    /**
     * @return \DateTime
     */
    public function getRangeTo()
    {
        return $this->rangeTo;
    }

    /**
     * @param string $result
     *
     * @return $this
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }
}
