<?php

namespace LaraCall\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\Dispatcher;
use LaraCall\Jobs\ForceFailJob;

class TestJobFailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:job_fail';

    /**
     * @var string
     */
    protected $description = 'Force send a failing job to the queue';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param Dispatcher $dispatcher
     */
    public function handle(Dispatcher $dispatcher)
    {
        $this->info('Sending failing job to the queue.');

        $dispatcher->dispatch(new ForceFailJob());
    }
}
