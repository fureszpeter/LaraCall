<?php

namespace LaraCall\Console\Commands;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Console\Command;
use LaraCall\Domain\Factories\PayPalIpnFactory;
use LaraCall\Domain\Repositories\UserRepository;
use PDO;

class ImportPayPalIpnCommand extends Command
{
    /** @var string */
    protected $signature = 'import:ipn {--I|ipn=}';

    /** @var string */
    protected $description = 'Import IPN messages';

    /**
     * @param PDO                    $pdo
     * @param EntityManagerInterface $em
     * @param UserRepository         $userRepository
     * @param PayPalIpnFactory       $ipnFactory
     */
    public function handle(
        PDO $pdo,
        EntityManagerInterface $em,
        UserRepository $userRepository,
        PayPalIpnFactory $ipnFactory
    ) {
        $ipnInput = $this->option('ipn');

        $condition = $ipnInput ? 'AND ipn_id=:ipn_id' : '';

        $sql       = 'SELECT 
                        * 
                      FROM 
                        `pay_pal_ipns` 
                      WHERE 
                        `payment_status`=\'Completed\' ' . $condition . ' 
                      ORDER BY 
                        `date_received` 
                      ASC';
        $statement = $pdo->prepare($sql);

        $bindParams = $ipnInput
            ? [':ipn_id' => $ipnInput]
            : [];

        $statement->execute($bindParams);

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $payPalIpn  = $ipnFactory->createFromArray(json_decode($row['ipn_message'], true));
            $userEntity = $userRepository->findOneBy(['email' => $payPalIpn->getPayerEmail()]);

            if (!$userEntity) {
                $this->error(
                    sprintf(
                        'User not found. [email: %s, transaction id: %s]',
                        $payPalIpn->getPayerEmail(),
                        $payPalIpn->getTxnId()
                    )
                );

                continue;
            }

            if (!$userEntity->getSubscription()) {
                $this->error(
                    sprintf('User has no subscription. [email: %s]', $userEntity->getEmail())
                );

                $em->detach($userEntity);
                continue;
            }

            $this->info(sprintf('Incrementing subscription for user. [email: %s]', $userEntity->getEmail()));
            $userEntity->getSubscription()->addPaymentEvent(
                $payPalIpn->getDateOfTransaction(),
                $payPalIpn->getGrossAmount()
            );
            $em->flush();
        }
    }
}
