<?php

namespace LaraCall\Console\Commands;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Console\Command;
use LaraCall\Domain\PayPal\ValueObjects\PayPalIpn;
use LaraCall\Domain\Repositories\UserRepository;
use PDO;

class ImportPayPalIpnCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:ipn {--I|ipn=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import IPN messages';

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
     * @param PDO                    $pdo
     * @param EntityManagerInterface $em
     * @param UserRepository         $userRepository
     */
    public function handle(PDO $pdo, EntityManagerInterface $em, UserRepository $userRepository)
    {
        $ipnInput = $this->option('ipn');

        $condition = $ipnInput ? 'AND ipn_id=:ipn_id' : '';

        $sql       = 'select * from `paypal_ipn` where `status`=\'AmountAdded\' ' . $condition . ' ORDER BY `date_received` ASC';
        $statement = $pdo->prepare($sql);

        $bindParams = $ipnInput
            ? [':ipn_id' => $ipnInput]
            : [];

        $statement->execute($bindParams);

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $ipnMessage = new PayPalIpn(unserialize($row['ipn_message']));
            $userEntity = $userRepository->findOneBy(['email' => $ipnMessage->getPayerEmail()]);

            if ( ! $userEntity) {
                $this->error(
                    sprintf(
                        'User not found. [email: %s, transaction id: %s]',
                        $ipnMessage->getPayerEmail(),
                        $ipnMessage->getTxnId()
                    )
                );

                continue;
            }

            if ( ! $userEntity->getSubscription()) {
                $this->error(
                    sprintf('User has no subscription. [email: %s]', $userEntity->getEmail())
                );

                $em->detach($userEntity);
                continue;
            }

            $this->info(sprintf('Incrementing subscription for user. [email: %s]', $userEntity->getEmail()));
            $userEntity->getSubscription()->addPaymentEvent(
                $ipnMessage->getDateOfTransaction(),
                $ipnMessage->getGrossAmount()
            );
            $em->flush();
        }
    }
}
