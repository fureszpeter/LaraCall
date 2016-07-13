<?php
namespace LaraCall\Domain\Services;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use LaraCall\Domain\DTOs\UserImportRowDto;
use LaraCall\Domain\Entities\Subscription;
use LaraCall\Domain\Entities\User;
use LaraCall\Domain\Repositories\CountryRepository;
use LaraCall\Domain\Repositories\StateRepository;
use LaraCall\Domain\Repositories\UserRepository;
use LaraCall\Domain\ValueObjects\Password;
use LaraCall\Domain\ValueObjects\Pin;
use LaraCall\Domain\ValueObjects\UserContactDetails;
use ValueObjects\Web\EmailAddress;

class UserImportService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var CountryRepository
     */
    private $countryRepository;

    /**
     * @var StateRepository
     */
    private $stateRepository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @param UserRepository         $userRepository
     * @param CountryRepository      $countryRepository
     * @param StateRepository        $stateRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(
        UserRepository $userRepository,
        CountryRepository $countryRepository,
        StateRepository $stateRepository,
        EntityManagerInterface $em
    ) {
        $this->userRepository    = $userRepository;
        $this->countryRepository = $countryRepository;
        $this->stateRepository   = $stateRepository;
        $this->em                = $em;
    }

    /**
     * @param UserImportRowDto $dto
     *
     * @throws NonUniqueResultException If user is non unique
     *
     * @return User
     */
    public function processRow(UserImportRowDto $dto)
    {
        $user = $this->userRepository->findOneBy(['email' => $dto->getEmail()]);

        if ($user) {
            throw new NonUniqueResultException('User already exists. ' . $dto->getEmail());
        }

        $user = new User(new EmailAddress($dto->getEmail()));
        $user->setPassword(new Password($dto->getPassword()));
        $user->setRegistrationDate($dto->getCreationDate());

        $country = null;
        $state   = null;

        if ($dto->getCountry()) {
            $country = $this->countryRepository->getOneBy(['isoalpha3' => $dto->getCountry()]);
            if ($country->getIsoalpha3() == 'USA') {
                $state = $this->stateRepository->getOneBy(['abbrev' => $dto->getState()]);
            }
        }

        $contact = new UserContactDetails(
            $dto->getFirstName() ?: '',
            $dto->getLastName() ?: '',
            $dto->getZipCode() ?: '',
            $dto->getAddress() ?: '',
            '',
            $dto->getPhone() ?: '',
            $country,
            $state
        );

        $user->setContact($contact);

        $this->userRepository->save($user);
        $this->em->flush();
        $this->em->clear();

        return $user;
    }

    /**
     * @param User             $user
     * @param UserImportRowDto $dto
     */
    public function addSubscription(User $user, UserImportRowDto $dto)
    {
        $this->em->persist($user);

        $subscription = new Subscription($user, new Pin($dto->getPin()));

        $user->setSubscription($subscription);

        $this->em->flush();
//        $this->em->clear();
    }

    /**
     * @param EmailAddress $emailAddress
     *
     * @return User
     */
    public function resetPins(EmailAddress $emailAddress)
    {
        $user = $this->userRepository->getOneBy(['email' => $emailAddress]);

        $user->resetPins();

        return $user;
    }

    /**
     * @param EmailAddress $emailAddress
     */
    public function resetSubscriptions(EmailAddress $emailAddress)
    {
        $user = $this->userRepository->getOneBy(['email' => $emailAddress]);

        if ($subscription = $user->getSubscription()) {
            $this->em->remove($subscription);
        }

        $this->em->flush();
    }
}
