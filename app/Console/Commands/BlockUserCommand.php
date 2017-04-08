<?php

namespace LaraCall\Console\Commands;

use A2bApiClient\Client;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Console\Command;
use LaraCall\Domain\Entities\Embeddables\BlockedEmbeddable;
use LaraCall\Domain\Repositories\UserRepository;

class BlockUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:block {id : id of the user} {reason : reason of the blocking.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Block user';

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
     * @param EntityManagerInterface $em
     * @param UserRepository         $userRepository
     * @param Client                 $a2bClient
     */
    public function handle(EntityManagerInterface $em, UserRepository $userRepository, Client $a2bClient)
    {
        $user = $userRepository->get($this->argument('id'));

        $em->beginTransaction();
        $user->setBlocked(new BlockedEmbeddable(
                true,
                $this->argument('reason')
            )
        );
        $em->persist($user);
        $em->flush();
        try {
            $a2bClient->getSubscription()->blockByPin($user->getSubscription()->getDefaultPin()->getPin());
            $em->commit();
        } catch (Exception $exception) {
            $em->rollback();
        }
    }
}
