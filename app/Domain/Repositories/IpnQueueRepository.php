<?php

namespace LaraCall\Domain\Repositories;

use Doctrine\Common\Persistence\ObjectRepository;
use LaraCall\Domain\Entities\IpnQueue;

interface IpnQueueRepository extends ObjectRepository
{
    public function get(int $id): IpnQueue;

    public function save(IpnQueue $ipnQueue): IpnQueue;
}
