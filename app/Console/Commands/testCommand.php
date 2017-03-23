<?php

namespace LaraCall\Console\Commands;

use Illuminate\Console\Command;
use LaraCall\Jobs\SendTestEmailJob;

class testCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send testmail job to queue';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $job = new SendTestEmailJob();
        dispatch($job);
    }
}
