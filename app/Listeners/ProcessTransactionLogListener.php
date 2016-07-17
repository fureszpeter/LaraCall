<?php
namespace LaraCall\Listeners;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Foundation\Bus\DispatchesJobs;
use LaraCall\Domain\Events\TransactionLogCreatedEvent;
use LaraCall\Jobs\ProcessTransactionJob;

/**
 * Class ProcessTransactionLog.
 *
 * @package LaraCall\Listeners
 */
class ProcessTransactionLogListener
{
    use DispatchesJobs;
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
     * @param TransactionLogCreatedEvent $event
     */
    public function handle(TransactionLogCreatedEvent $event)
    {
        $job = new ProcessTransactionJob($event->getTransactionLog());
        $this->dispatch($job);
    }
}
