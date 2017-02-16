<?php

namespace LaraCall\Console\Commands;

use A2bApiClient\Exceptions\A2bApiException;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Console\Command;
use LaraCall\Domain\Entities\Pin;
use LaraCall\Domain\Entities\Subscription;
use LaraCall\Domain\Entities\User;
use LaraCall\Domain\Repositories\CountryRepository;
use LaraCall\Domain\Repositories\PinRepository;
use LaraCall\Domain\Repositories\StateRepository;
use LaraCall\Domain\Repositories\UserRepository;
use OutOfBoundsException;
use PDO;

class ImportSubscriptionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:subscription {--E|email=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var PinRepository
     */
    private $pinRepository;

    /**
     * @var CountryRepository
     */
    private $countryRepository;

    /**
     * @var StateRepository
     */
    private $stateRepository;

    /**
     * Create a new command instance.
     *
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
     *
     * @param PinRepository          $pinRepository
     * @param CountryRepository      $countryRepository
     * @param StateRepository        $stateRepository
     * @param PDO                    $pdo
     */
    public function handle(
        EntityManagerInterface $em,
        UserRepository $userRepository,
        PinRepository $pinRepository,
        CountryRepository $countryRepository,
        StateRepository $stateRepository,
        PDO $pdo
    ) {
        $this->em                = $em;
        $this->pdo               = $pdo;
        $this->userRepository    = $userRepository;
        $this->pinRepository     = $pinRepository;
        $this->countryRepository = $countryRepository;
        $this->stateRepository   = $stateRepository;

        $email = $this->option('email');

        if ($email) {
            $users = $userRepository->findBy(['email' => $email]);
        } else {
            $users = $userRepository->findAll();
        }

        foreach ($users as $user) {
            $sql       = 'SELECT * FROM cc_card c WHERE email=:email ORDER BY creationdate DESC';
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':email' => $user->getEmail(),
            ]);

            $pins = $statement->fetchAll(PDO::FETCH_ASSOC);

            foreach ($pins as $pin) {
                try {
                    $this->createSubscriptionIfNeeded($user, $pin);
                } catch (OutOfBoundsException $exception) {
                    $this->error(
                        sprintf(
                            'Country or state not found for user. [email: %s, $id: %s, message: %s]',
                            $user->getEmail(),
                            $pin['username'],
                            $exception->getMessage()
                        )
                    );
                    continue;
                }
            }
        }
    }

    /**
     * @param User  $user
     * @param array $pin
     *
     * @throws OutOfBoundsException If country or state not found.
     */
    private function createSubscriptionIfNeeded(User $user, array $pin)
    {
        $this->em->beginTransaction();
        $subscription = $user->getSubscription();

        try {
            if ( ! $subscription) {
                $this->info(sprintf('Creating subscription for user. [email: %s]', $user->getEmail()));
                $subscription = $this->createSubscription($pin, $user);
            }

        } catch (OutOfBoundsException $e) {
            $this->em->rollback();
            throw $e;
        }

        $pinEntity = $this->pinRepository->find($pin['username']);

        if ( ! $pinEntity) {
            $this->info(
                sprintf('Creating PIN for user. [pin: %s, email: %s]', $pin['username'], $user->getEmail())
            );

            $pinEntity = new Pin($pin['username'], $subscription);
            $pinEntity->setCreatedAt(new DateTime($pin['creationdate']));
            $subscription->setDefaultPin($pinEntity);
            $this->em->persist($pinEntity);
        }

        if ( ! $pinEntity->getSubscription()) {
            $pinEntity->setSubscription($subscription);
        }
        $this->em->commit();
    }

    /**
     * @param array $pin
     * @param User  $user
     *
     * @throws OutOfBoundsException if country or state not found.
     *
     * @return Subscription
     */
    private function createSubscription(array $pin, User $user): Subscription
    {
        $countryEntity = $this->countryRepository->getOneBy(['isoAlpha3' => $pin['country']]);
        $stateEntity   = null;
        if ($countryEntity->getCountryCode() == 'US') {
            $stateEntity = $this->stateRepository->getOneBy(['stateCode' => $pin['state']]);
        }

        $createdAt    = new DateTime($pin['creationdate']);
        $subscription = new Subscription(
            $user,
            $countryEntity,
            $pin['firstname'],
            $pin['lastname'],
            $pin['zipcode'],
            $pin['city'],
            $pin['address'],
            $pin['tariff'],
            null,
            $stateEntity,
            $createdAt
        );
        $subscription->setCreatedAt($createdAt);

        $this->em->persist($subscription);
        $user->setSubscription($subscription);
        $this->em->flush();

        return $subscription;
    }

}
