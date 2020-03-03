<?php

namespace LaraCall\Domain\Entities;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use LaraCall\Events\IpnStoredToQueueEvent;

/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="\LaraCall\Infrastructure\Repositories\DoctrineIpnQueueRepository")
 */
class IpnQueue extends AbstractEntityWithId
{
    /**
     * @ORM\Column(type="array", nullable=false)
     *
     * @var array
     */
    protected $rawData;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *
     * @var bool|null
     */
    protected $isPayPalTheSender;

    /**
     * @ORM\Column(type="array", nullable=true)
     *
     * @var array
     */
    protected $requestDetails;

    /**
     * @ORM\Column(type="integer", nullable=false)
     *
     * @var int
     */
    protected $tryCount = 0;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var DateTimeImmutable
     */
    protected $processed;

    /**
     * @param array $rawData
     * @param array $requestDetails
     */
    public function __construct(array $rawData, array $requestDetails)
    {
        parent::__construct();

        $this->rawData           = $rawData;
        $this->requestDetails    = $requestDetails;
    }

    /**
     * @return array
     */
    public function getRawData(): array
    {
        return $this->rawData;
    }

    /**
     * @return bool|null
     */
    public function isPayPalTheSender(): ?bool
    {
        return $this->isPayPalTheSender;
    }

    /**
     * @param bool $isPayPalTheSender
     *
     * @return $this
     */
    public function setIsPayPalTheSender(bool $isPayPalTheSender): self
    {
        $this->isPayPalTheSender = $isPayPalTheSender;

        return $this;
    }

    /**
     * @return array
     */
    public function getRequestDetails(): array
    {
        return $this->requestDetails;
    }

    /**
     * @return $this
     */
    public function increaseTryCount(): self
    {
        $this->tryCount++;

        return $this;
    }

    /**
     * @param DateTimeImmutable $processed
     *
     * @return $this
     */
    public function setProcessed(DateTimeImmutable $processed): self
    {
        $this->processed = $processed;

        return $this;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getProcessed(): ?DateTimeImmutable
    {
        return $this->processed;
    }

    /**
     * @ORM\PostPersist()
     */
    public function postPersist()
    {
        event(new IpnStoredToQueueEvent($this->getId()));
    }
}
