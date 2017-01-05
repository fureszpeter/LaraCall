<?php

namespace LaraCall\Console\Commands;

use Doctrine\ORM\EntityManager;
use Illuminate\Console\Command;
use LaraCall\Domain\Entities\IpnSalesMessageEntity;
use LaraCall\Domain\PayPal\ValueObjects\IpnSalesMessage;
use Symfony\Component\Console\Helper\Table;

class ListPayPalIpnMessagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ipn:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param EntityManager $em
     */
    public function handle(EntityManager $em)
    {
        $builder = $em->createQueryBuilder();
        $query   = $builder
            ->addSelect(['ipn'])
            ->from(IpnSalesMessageEntity::class, 'ipn')
            ->orderBy('ipn.dateReceived', 'DESC')
            ->setMaxResults(10)
            ->getQuery();

        $result = $query->getResult();

        $header = ! empty($result)
            ? array_keys(current($result)->jsonSerialize())
            : array_keys(
                (new IpnSalesMessageEntity(
                    new IpnSalesMessage([]),
                    false
                ))->jsonSerialize()
            );


        $table = new Table($this->getOutput());
        $table->setHeaders($header);

        foreach ($result as $entity) {
            $table->addRow($entity->jsonSerialize());
        }

        $table->render();
    }
}
