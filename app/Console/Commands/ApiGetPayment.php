<?php

namespace LaraCall\Console\Commands;

use A2bApiClient\Client;
use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\Table;

class ApiGetPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:payment:list {subscriptionId : Id of the subscription}';

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
     * @param Client $client
     *
     * @return mixed
     */
    public function handle(Client $client)
    {
        $payments = $client->getPayment($this->argument('subscriptionId'))->list();

        if ( ! empty($payments)) {
            $table = new Table($this->getOutput());
            $table->setHeaders(array_keys(current($payments)->getBag()));
            foreach ($payments as $payment) {
                $table->addRow($payment->getBag());
            }
            $table->render();
        }
    }
}
