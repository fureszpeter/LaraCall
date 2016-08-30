<?php

namespace LaraCall\Domain\Repositories;

use Doctrine\Common\Persistence\ObjectRepository;

interface ApiCronLogRepository extends ObjectRepository
{
    /**
     * @return \DateTime
     *
     * @throws \OutOfBoundsException If sync never happened.
     */
    public function getLastSyncDate();
}
