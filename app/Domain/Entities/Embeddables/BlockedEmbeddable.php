<?php
namespace LaraCall\Domain\Entities\Embeddables;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * Class UserBlocked.
 *
 * @package LaraCall
 *
 * @license Proprietary
 *
 * @ORM\Embeddable()
 */
class BlockedEmbeddable implements JsonSerializable
{
    /**
     * @var DateTime|null
     *
     * @ORM\Column(type="datetimetz", nullable=true)
     */
    protected $dateBlocked;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $status;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $reason;

    /**
     * @param bool        $blocked
     * @param string|null $reason
     */
    public function __construct(bool $blocked, string $reason = null)
    {
        $this->status      = $blocked;
        $this->reason      = $reason;
        $this->dateBlocked = $blocked ? new DateTime() : null;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'status' => $this->getStatus(),
            'date'   => $this->getDateBlocked(),
            'reason' => $this->getReason(),
        ];
    }

    /**
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->status;
    }

    /**
     * @param bool $status
     *
     * @return $this
     */
    public function setStatus(bool $status)
    {
        $this->dateBlocked = $status ? new DateTime() : null;
        $this->status      = $status;

        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDateBlocked(): ?DateTime
    {
        return $this->dateBlocked;
    }

    /**
     * @return string|null
     */
    public function getReason(): ?string
    {
        return $this->reason;
    }
}
