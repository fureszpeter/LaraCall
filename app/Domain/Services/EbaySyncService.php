<?php
namespace LaraCall\Domain\Services;

use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use LaraCall\Domain\Entities\EbaySyncLog;

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
     * @return DateTimeImmutable|null
     */
    public function getLastSyncDate()
    {
        /** @var EbaySyncLog[] $result */
        $result = $this->em->getRepository(EbaySyncLog::class)->findBy([], ['rangeTo' => 'DESC'], 1);

        $syncLog = current($result);

        return !empty($result) ? DateTimeImmutable::createFromMutable($syncLog->getRangeTo()) : null;
    }
}
