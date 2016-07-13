<?php

namespace LaraCall\Domain\Entities;

use Carbon\Carbon;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Furesz\TypeChecker\TypeChecker;

/**
 * Class EbayTransactionLog.
 *
 * @ORM\Entity()
 */
class EbayTransactionLog
{
    /**
     * @var string
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(name="transaction_id", type="string", unique=true, nullable=false)
     */
    private $transactionId;

    /**
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $updatedAt;

    /**
     * @var string
     */
    protected $sellerUserName;

    /**
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $transactionDate;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=false)
     */
    protected $transactionData;

    /**
     * @var ApiCronLog|null
     *
     * @ORM\ManyToOne(targetEntity="ApiCronLog")
     * @ORM\JoinColumn(name="cron_id", referencedColumnName="id" , nullable=true)
     */
    protected $cronLog;

    /**
     * @param string            $transactionId
     * @param string            $sellerUserName
     * @param DateTimeInterface $transactionDate
     * @param string            $transactionData
     */
    public function __construct($transactionId, $sellerUserName, DateTimeInterface $transactionDate, $transactionData)
    {
        TypeChecker::assertString($transactionId, '$transactionId');
        TypeChecker::assertString($sellerUserName, '$sellerUserName');
        TypeChecker::assertString($transactionData, '$transactionData');

        $this->createdAt = Carbon::now();
        $this->updatedAt = Carbon::now();


        $this->transactionId = $transactionId;
        $this->sellerUserName = $sellerUserName;
        $this->transactionDate = $transactionDate;
        $this->transactionData = $transactionData;
    }

    /**
     * @param ApiCronLog|null $cronLog
     *
     * @return $this
     */
    public function setCronLog(ApiCronLog $cronLog)
    {
        $this->cronLog = $cronLog;

        return $this;
    }

    /**
     * @return ApiCronLog|null
     */
    public function getCronLog()
    {
        return $this->cronLog;
    }

    /**
     * @return string
     */
    public function getSellerUserName()
    {
        return $this->sellerUserName;
    }

    /**
     * @return DateTimeInterface
     */
    public function getTransactionDate()
    {
        return $this->transactionDate;
    }

    /**
     * @return string
     */
    public function getTransactionData()
    {
        return $this->transactionData;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return DateTimeInterface
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
