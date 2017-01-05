<?php
namespace LaraCall\Domain\Entities;

use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use LaraCall\Domain\PayPal\ValueObjects\IpnSalesMessage;
use LaraCall\Domain\ValueObjects\IpnStatus;

/**
 * Class IpnSalesMessageEntity.
 *
 * @package LaraCall
 *
 * @license Proprietary
 *
 * @ORM\Entity(repositoryClass="")
 */
class IpnSalesMessageEntity implements JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", unique=true, nullable=false)
     */
    protected $id;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $dateReceived;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dateProcessed;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $dateUpdated;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $status;

    /**
     * @var bool|null
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $isValid;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $isSandBox;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=false)
     */
    protected $salesMessage;

    /**
     * @param IpnSalesMessage $saleMessage
     * @param bool            $isValid
     */
    public function __construct(IpnSalesMessage $saleMessage, bool $isValid)
    {
        $this->salesMessage = json_encode($saleMessage);
        $this->isSandBox    = $saleMessage->isSandBox();
        $this->status       = (string) new IpnStatus(IpnStatus::STATUS_UNPROCESSED);
        $this->dateReceived = new DateTimeImmutable();
        $this->dateUpdated  = new DateTimeImmutable();
        $this->isValid      = $isValid;
    }

    /**
     * @return IpnSalesMessage
     */
    public function getSalesMessage(): IpnSalesMessage
    {
        return new IpnSalesMessage(json_decode($this->salesMessage));
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $implode = implode(', ', $this->jsonSerialize());

        return $implode;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id'            => $this->getId(),
            'dateReceived'  => $this->getDateReceived()->format(DATE_ISO8601),
            'dateProcessed' => $this->getDateProcessed() ? $this->getDateProcessed()->format(DATE_ISO8601) : null,
            'dateUpdated'   => $this->getDateUpdated()->format(DATE_ISO8601),
            'status'        => $this->getStatus(),
            'isValid'       => $this->isIsValid(),
            'isSandBox'     => $this->isIsSandBox(),
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDateReceived(): DateTimeImmutable
    {
        return DateTimeImmutable::createFromMutable($this->dateReceived);
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getDateProcessed()
    {
        return $this->dateProcessed
            ? DateTimeImmutable::createFromMutable($this->dateProcessed)
            : null;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDateUpdated(): DateTimeImmutable
    {
        return DateTimeImmutable::createFromMutable($this->dateUpdated);
    }

    /**
     * @param DateTimeImmutable $dateUpdated
     *
     * @return $this
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }

    /**
     * @return IpnStatus
     */
    public function getStatus(): IpnStatus
    {
        return new IpnStatus($this->status);
    }

    /**
     * @param IpnStatus $status
     *
     * @return $this
     */
    public function setStatus(IpnStatus $status)
    {
        $this->status = (string) $status;

        return $this;
    }

    /**
     * @return bool
     */
    public function isIsValid(): bool
    {
        return $this->isValid;
    }

    /**
     * @return bool
     */
    public function isIsSandBox(): bool
    {
        return $this->isSandBox;
    }
}
