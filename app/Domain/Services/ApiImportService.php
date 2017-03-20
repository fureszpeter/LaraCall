<?php
namespace LaraCall\Domain\Services;

use A2bApiClient\Api\Instances\SubscriptionInstance;
use A2bApiClient\Client;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use LaraCall\Domain\Collections\PinCollection;
use LaraCall\Domain\Entities\Embeddables\BlockedEmbeddable;
use LaraCall\Domain\Entities\Pin;
use LaraCall\Domain\Entities\Subscription;
use LaraCall\Domain\Entities\User;
use LaraCall\Domain\Repositories\CountryRepository;
use LaraCall\Domain\Repositories\PinRepository;
use LaraCall\Domain\Repositories\StateRepository;
use LaraCall\Domain\Repositories\SubscriptionRepository;
use LaraCall\Domain\Repositories\UserRepository;
use LaraCall\Domain\ValueObjects\SubscriptionStatus;
use OutOfBoundsException;

class ApiImportService implements ImportService
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var CountryRepository
     */
    private $countryRepository;

    /**
     * @var StateRepository
     */
    private $stateRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var SubscriptionRepository
     */
    private $subscriptionRepository;

    /**
     * @var PinRepository
     */
    private $pinRepository;

    /**
     * @param Client                 $client
     * @param EntityManagerInterface $em
     * @param CountryRepository      $countryRepository
     * @param StateRepository        $stateRepository
     * @param UserRepository         $userRepository
     * @param SubscriptionRepository $subscriptionRepository
     * @param PinRepository          $pinRepository
     */
    public function __construct(
        Client $client,
        EntityManagerInterface $em,
        CountryRepository $countryRepository,
        StateRepository $stateRepository,
        UserRepository $userRepository,
        SubscriptionRepository $subscriptionRepository,
        PinRepository $pinRepository
    ) {
        $this->client                 = $client;
        $this->em                     = $em;
        $this->countryRepository      = $countryRepository;
        $this->stateRepository        = $stateRepository;
        $this->userRepository         = $userRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->pinRepository          = $pinRepository;
    }

    /**
     * @param string $email
     *
     * @return PinCollection
     */
    public function importByEmail(string $email): PinCollection
    {
        try {
            $subscriptionInstances = $this->client->getSubscription()->getByEmail($email);
            $pinCollection         = $this->em->transactional(function () use ($subscriptionInstances) {
                return $this->importSubscriptionInstances(...$subscriptionInstances);
            });
        } catch (OutOfBoundsException $e) {
            $pinCollection = new PinCollection();
        }

        return $pinCollection;
    }

    /**
     * @param SubscriptionInstance[] ...$subscriptionInstances
     *
     * @return PinCollection
     */
    public function importSubscriptionInstances(SubscriptionInstance ...$subscriptionInstances): PinCollection
    {
        $pinCollection = new PinCollection();
        foreach ($subscriptionInstances as $subscriptionInstance) {
            $pinCollection->add($this->importSubscriptionInstance($subscriptionInstance));

        }

        return $pinCollection;
    }

    /**
     * @param SubscriptionInstance $subscriptionInstance
     *
     * @return Pin
     */
    public function importSubscriptionInstance(SubscriptionInstance $subscriptionInstance): Pin
    {
        $user         = $this->userRepository->findOneBy(['email' => $subscriptionInstance->email]) ?: $this->importUser($subscriptionInstance);
        $subscription = $user->getSubscription() ?: $this->importSubscription($subscriptionInstance, $user);
        $pin          = $this->pinRepository->find($subscriptionInstance->username) ?: $this->importPin($subscriptionInstance,
            $subscription);

        $subscription->setDefaultPin($pin);
        $user->setSubscription($subscription);

        return $pin;
    }

    /**
     * @param SubscriptionInstance $subscriptionInstance
     *
     * @return User
     */
    public function importUser(SubscriptionInstance $subscriptionInstance): User
    {
        $repository = $this->em->getRepository(User::class);

        $user = $repository->findOneBy(['email' => $subscriptionInstance->email]);

        if ($user) {
            return $user;
        }

        $status = new SubscriptionStatus($subscriptionInstance->status);

        return $this->saveUser($subscriptionInstance, $status);
    }

    /**
     * @param SubscriptionInstance $subscription
     * @param SubscriptionStatus   $status
     *
     * @return User
     */
    private function saveUser(SubscriptionInstance $subscription, SubscriptionStatus $status): User
    {
        $user = new User(
            $subscription->email,
            $subscription->uipass
        );
        $this->em->persist($user);
        $user->setRegistrationDate(new DateTime($subscription->creationdate));
        if ($status->isBlocked()) {
            $user->setBlocked(new BlockedEmbeddable(true));
        }
        $this->em->flush();

        return $user;
    }

    /**
     * @param SubscriptionInstance $subscriptionInstance
     * @param User                 $user
     *
     * @return Subscription
     */
    public function importSubscription(SubscriptionInstance $subscriptionInstance, User $user): Subscription
    {
        $subscription = $user->getSubscription();
        if ($subscription) {
            return $subscription;
        }

        $country = $this->countryRepository->get($subscriptionInstance->country);
        $state   = $country->getIsoAlpha3() == 'USA'
            ? $this->stateRepository->get($subscriptionInstance->state)
            : null;

        $subscription = new Subscription(
            $user,
            $country,
            $subscriptionInstance->firstname,
            $subscriptionInstance->lastname,
            $subscriptionInstance->zipcode,
            $subscriptionInstance->city,
            $subscriptionInstance->address,
            $subscriptionInstance->tariff,
            null,
            $state,
            new DateTime($subscriptionInstance->creationdate)
        );
        $this->em->persist($subscription);
        $this->em->flush();

        return $subscription;
    }

    /**
     *
     * @param SubscriptionInstance $subscriptionInstance
     * @param Subscription         $subscription
     *
     * @return Pin
     */
    public function importPin(SubscriptionInstance $subscriptionInstance, Subscription $subscription): Pin
    {
        $repository = $this->em->getRepository(Pin::class);
        $pinEntity  = $repository->find($subscriptionInstance->username);

        if ($pinEntity) {
            return $pinEntity;
        }

        $status = new SubscriptionStatus($subscriptionInstance->status);
        $pin    = new Pin($subscriptionInstance->username, $subscription);
        $pin->setCreatedAt(new DateTime($subscriptionInstance->creationdate));
        if ($status->isBlocked()) {
            $pin->setBlocked(new BlockedEmbeddable(true));
        }
        $this->em->persist($pin);
        $subscription->setDefaultPin($pin);
        $this->em->flush();

        return $pin;
    }
}
