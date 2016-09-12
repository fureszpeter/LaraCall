<?php

namespace LaraCall\Domain\Services;

/**
 * Interface SyncService
 *
 * @package LaraCall\Domain\Services
 */
interface SyncService
{
    /**
     * @return \DateTimeImmutable|null
     */
    public function getLastSyncDate();
}
