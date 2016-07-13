<?php

namespace LaraCall\Console\Commands;

use Illuminate\Console\Command;
use LaraCall\Domain\Services\EbayService;

class EbayAccountInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ebay:account:info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dump the info about the connected user.';

    /**
     * @var EbayService
     */
    private $service;

    /**
     * Create a new command instance.
     *
     * @param EbayService $service
     */
    public function __construct(EbayService $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info(
            'Info: ' . json_encode(
                $this->service->getAccountInfo(),
                JSON_PRETTY_PRINT
            )
        );
    }
}
