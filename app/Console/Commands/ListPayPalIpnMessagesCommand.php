<?php

namespace LaraCall\Console\Commands;

use Illuminate\Console\Command;
use LaraCall\Domain\Entities\PayPalIpn;
use LaraCall\Domain\Repositories\PayPalIpnRepository;
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
     * @param PayPalIpnRepository $repository
     */
    public function handle(PayPalIpnRepository $repository)
    {
        $ipnSalesMessages = $repository->findLast(10);

        $table = new Table($this->getOutput());
        $table->setHeaders(PayPalIpn::getHeaders());

        foreach ($ipnSalesMessages as $ipnSalesMessage) {
            $table->addRow($ipnSalesMessage->jsonSerialize());
        }

        $table->render();
    }
}
