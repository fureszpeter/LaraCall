<?php
namespace LaraCall\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Output\ConsoleOutputInterface;

abstract class AbstractCommand extends Command
{
    /**
     * @var \Symfony\Component\Console\Output\OutputInterface
     */
    protected $stderr;

    public function __construct()
    {
        parent::__construct();
        $output = $this->getOutput();
        if ($output instanceof ConsoleOutputInterface) {
            $this->stderr = $output->getErrorOutput();
        }
    }

    public function error($string, $verbosity = null)
    {
        $this->stderr->writeln('<error>'.$string.'</error>');
    }
}
