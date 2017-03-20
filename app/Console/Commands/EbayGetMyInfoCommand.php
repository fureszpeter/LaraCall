<?php

namespace LaraCall\Console\Commands;

use Illuminate\Console\Command;
use LaraCall\Infrastructure\Services\Ebay\EbayApiService;

class EbayGetMyInfoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ebay:myinfo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get my (the seller) detailed info';

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
        $info = $service->getMyInfo();

        $this->info(var_export($info, true));
    }
}
