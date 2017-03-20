<?php

namespace LaraCall\Console\Commands;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Console\Command;
use LaraCall\Domain\Entities\Embeddables\BlockedEmbeddable;
use LaraCall\Domain\Entities\User;
use LaraCall\Domain\Repositories\UserRepository;
use LaraCall\Domain\Services\PasswordService;
use PDO;

class ImportUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:users {--E|email=}';

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
     * @param PDO                    $pdo
     *
     * @param EntityManagerInterface $em
     * @param PasswordService        $passwordService
     *
     * @param UserRepository         $userRepository
     *
     * @return mixed
     */
    public function handle(
        PDO $pdo,
        EntityManagerInterface $em,
        PasswordService $passwordService,
        UserRepository $userRepository
    ) {
        $emailCondition = $this->option('email')
            ? 'c.email=:email'
            : '1=1';

        $sql = 'SELECT 
    IFNULL(c.email, tu.email) email, 
    uipass, 
    creationdate,
    (case status 
		WHEN 0 THEN \'cancelled\'
        WHEN 1 THEN \'active\'
        WHEN 2 THEN \'active\'
        WHEN 5 THEN \'expired\'
        WHEN 8 THEN \'wait-pay\'
	end) as status
FROM
    mya2billing.cc_card c
        LEFT JOIN
    temp_users tu ON (c.id = tu.id_card_id)
INNER JOIN (
	SELECT IFNULL(c2.email, tu2.email) email2, max(creationdate) as maxdate
    FROM mya2billing.cc_card c2 LEFT JOIN temp_users tu2 ON (c2.id = tu2.id_card_id)
    WHERE IFNULL(c2.email, tu2.email) !=\'\' GROUP BY email2
) tm
ON tm.maxdate = c.creationdate AND tm.email2 = IFNULL(c.email, tu.email)
WHERE 1=1 AND ' . $emailCondition . '   
ORDER BY IFNULL(c.email, tu.email) ASC , creationdate DESC;';

        $statement = $pdo->prepare($sql);
        $bindings  = [];

        if ($emailCondition != '') {
            $bindings[':email'] = $this->option('email');
        }

        $statement->execute($bindings);

        while ($row = $statement->fetch()) {
            if ($user = $userRepository->findOneBy(['email' => $row['email']])) {

                $importedUserRegistrationDate = new DateTime($row['creationdate']);

                if ($user->getRegistrationDate() != $importedUserRegistrationDate) {
                    $this->info(sprintf('Updating user. [email: %s]', $row['email']));

                    $user->setRegistrationDate($importedUserRegistrationDate);
                    $user->setPassword($passwordService->encrypt($row['uipass']));
                    $em->flush();

                    continue;
                } else {
                    $this->warn(sprintf('Email already exists. [email: %s]', $row['email']));

                    continue;
                }
            }

            $user = new User($row['email'], $passwordService->encrypt($row['uipass']));
            $user->setRegistrationDate(new DateTime($row['creationdate']));

            if ($row['status'] == 'cancelled') {
                $user->setBlocked(new BlockedEmbeddable(true, 'fraud'));
            }

            $this->info(sprintf('Importing user: %s', json_encode($user, JSON_PRETTY_PRINT)));

            $em->persist($user);
            $em->flush();
            $em->clear();
        }
    }
}
