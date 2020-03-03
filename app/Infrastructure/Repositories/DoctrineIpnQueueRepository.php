<?php

namespace LaraCall\Infrastructure\Repositories;

use Doctrine\ORM\EntityRepository;
use LaraCall\Domain\Entities\IpnQueue;
use LaraCall\Domain\Repositories\IpnQueueRepository;
use OutOfBoundsException;

class DoctrineIpnQueueRepository extends EntityRepository implements IpnQueueRepository
{
    public function get(int $id): IpnQueue
    {
        $ipn = $this->find($id);

        if ($ipn instanceof IpnQueue) {
            return $ipn;
        }

        throw new OutOfBoundsException(
            sprintf('IpnQueue not found by id. [id: %s]', $id)
        );
    }

    public function save(IpnQueue $ipnQueue): IpnQueue
    {
        $this->_em->persist($ipnQueue);
        $this->_em->flush($ipnQueue);

        return $ipnQueue;
    }
}
