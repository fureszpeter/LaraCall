<?php
namespace LaraCall\Domain\Services;

/**
 * Class EbaySyncService.
 *
 * @package LaraCall
 *
 * @license Proprietary
 */
class EbaySyncService implements SyncService
{

    /**
     * @return \DateTime|null
     */
    public function getLastSyncDate()
    {
        // TODO: Implement getLastSyncDate() method.
        return new \DateTime();
    }
}
