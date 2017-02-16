<?php

namespace LaraCall\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\Dispatcher;
use LaraCall\Jobs\ProcessPayPalIpnJob;

/**
 * Class IpnProcessCommand.
 *
 * @package LaraCall
 *
 * @license Proprietary
 */
class IpnProcessCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ipn:process {ipnId : The IPN id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process an ebay ipn message.';

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
     * @param Dispatcher $dispatcher
     */
    public function handle(
        Dispatcher $dispatcher
    ) {
        $ipnId = $this->argument('ipnId');

        $dispatcher->dispatch(new ProcessPayPalIpnJob($ipnId));
    }

}
