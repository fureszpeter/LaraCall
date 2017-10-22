<?php

namespace LaraCall\Events;

class IpnStoredToQueueEvent extends Event
{
    /** @var int */
    private $ipnQueueId;

    /**
     * @param int $ipnQueueId
     */
    public function __construct(int $ipnQueueId)
    {
        $this->ipnQueueId = $ipnQueueId;
    }

    /**
     * @return int
     */
    public function getIpnQueueId(): int
    {
        return $this->ipnQueueId;
    }
}
