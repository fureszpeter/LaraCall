<?php

namespace LaraCall\Console\Commands;

use Doctrine\ORM\EntityManager;
use Illuminate\Console\Command;
use LaraCall\Domain\Entities\IpnSalesMessageEntity;
use LaraCall\Domain\Registration\Services\UserServiceInterface;

class IpnProcessCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ipn:process {id}';

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
     * @param UserServiceInterface $userService
     * @param EntityManager        $em
     */
    public function handle(UserServiceInterface $userService, EntityManager $em)
    {
        $repo = $em->getRepository(IpnSalesMessageEntity::class);
        $id   = $this->input->getArgument('id');

        $ipnMessageEntity = $repo->find($id);

        if (is_null($ipnMessageEntity)) {
            $this->error(
                sprintf('Ipn message not found with id: %s', $id)
            );

            return;
        }
    }
}
