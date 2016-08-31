<?php
namespace LaraCall\Domain\Services;

use Doctrine\ORM\EntityManagerInterface;
use LaraCall\Domain\Entities\EbaySyncLog;
use LaraCall\Domain\Repositories\ApiCronLogRepository;

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
     * @var EbaySyncLog
     */
    private $cronLogRepository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * @return \DateTime|null
     */
    public function getLastSyncDate()
    {
        $this->em->getRepository(EbaySyncLog::class)->findBy([
            'command' =>
        ]);
        // TODO: Implement getLastSyncDate() method.
        return new \DateTime();
    }
}
