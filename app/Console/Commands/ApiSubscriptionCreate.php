<?php

namespace LaraCall\Console\Commands;

use A2bApiClient\Api\SubscriptionCreateRequest;
use A2bApiClient\Client;
use Illuminate\Console\Command;

class ApiSubscriptionCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:subscription:create';

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
        $request = new SubscriptionCreateRequest(
            '1234567892',
            '123456789012346',
            '1234',
            13,
            'Peter',
            'Furesz',
            'To u. 4.',
            'Őrbottyán',
            'HUN',
            '2162',
            'fureszpeter@gmail.com',
            'HUF'
        );

        $this->info($client->getSubscription()->create($request));
    }
}
