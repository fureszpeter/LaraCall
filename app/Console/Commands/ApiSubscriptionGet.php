<?php

namespace LaraCall\Console\Commands;

use A2bApiClient\Client;
use Illuminate\Console\Command;

class ApiSubscriptionGet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:subscription:get {key : email or pin} {value : PIN code or email}';

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
        $value = $this->argument('value');

        switch ($this->argument('key')) {
            case 'pin':
                $response = $client->getSubscription()->getByPin($value);
                $this->info(json_encode($response));

                break;
            case 'email':
                $response = $client->getSubscription()->getByEmail($value);
                $this->info(json_encode($response));

                break;
            case 'id':
                $response = $client->getSubscription()->getById($value);
                $this->info(json_encode($response));

                break;
        }
    }
}
