<?php
namespace LaraCall\Events;

use Illuminate\Queue\SerializesModels;

class PayIpnEntityCreatedEvent extends Event
{
    use SerializesModels;

    /**
     * @var int
     */
    private $ipnId;


    /**
     * @param int $ipnId
     */
    public function __construct(int $ipnId)
    {
        $this->ipnId = $ipnId;
    }

    /**
     * @return int
     */
    public function getIpnId(): int
    {
        return $this->ipnId;
    }
}
