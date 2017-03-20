<?php

namespace LaraCall\Console\Commands;

use Illuminate\Console\Command;
use LaraCall\Infrastructure\Services\Ebay\EbayApiService;
use LaraCall\Infrastructure\Services\Ebay\ValueObjects\ItemId;

class EbayGetUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ebay:user {username : The username of the buyer} {--I|itemId= : The ItemId of the transaction}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the user information by username';

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
     * @param EbayApiService $service
     *
     * @return mixed
     */
    public function handle(EbayApiService $service)
    {
        $userId = $this->argument('username');
        $itemId = $this->option('itemId') ? new ItemId($this->option('itemId')) : null;

        $result = $service->getUser($userId, $itemId);

        $this->info(var_export($result->toArray(), true));
    }
}
