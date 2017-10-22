<?php

namespace LaraCall\Console\Commands;

use Illuminate\Console\Command;
use LaraCall\Domain\Entities\PayPalIpnEntity;
use LaraCall\Domain\Repositories\PayPalIpnRepository;
use Symfony\Component\Console\Helper\Table;

class IpnListCommand extends Command
{
    /** @var string */
    protected $signature = 'ipn:list';

    /** @var string */
    protected $description = 'Command description';

    /**
     * @param PayPalIpnRepository $repository
     */
    public function handle(PayPalIpnRepository $repository)
    {
        $ipnSalesMessages = $repository->findLast(10);

        $table = new Table($this->getOutput());
        $table->setHeaders(PayPalIpnEntity::getHeaders());

        foreach ($ipnSalesMessages as $ipnSalesMessage) {
            $table->addRow($ipnSalesMessage->jsonSerialize());
        }

        $table->render();
    }
}
