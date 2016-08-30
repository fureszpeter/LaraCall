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
     * @return \DateTime|null
     */
    public function getLastSyncDate();
}
