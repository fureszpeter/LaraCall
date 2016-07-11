<?php
namespace LaraCall\Jobs;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use LaraCall\Domain\DTOs\UserImportRowDto;
use LaraCall\Domain\Entities\Country;
use LaraCall\Domain\Entities\State;
use LaraCall\Domain\Entities\User;
use LaraCall\Domain\ValueObjects\Password;
use LaraCall\Domain\ValueObjects\UserContactDetails;
use ValueObjects\Web\EmailAddress;

class ImportUserByDto
{
    /**
     * @var UserImportRowDto
     */
    private $row;

    /**
     * @param UserImportRowDto $row
     */
    public function __construct(UserImportRowDto $row)
    {
        $this->row = $row;
    }

    /**
     * @param EntityManagerInterface $em
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function handle(EntityManagerInterface $em)
    {
        $userRepository = $em->getRepository(User::class);
        $countryRepository = $em->getRepository(Country::class);
        $stateRepository = $em->getRepository(State::class);

        $user = $userRepository->findOneBy(['email' => $this->row->getEmail()]);

        if ($user) {
            throw new NonUniqueResultException('User already exists. ' . $this->row->getEmail());
            return true;
        }

            $user = new User(new EmailAddress($this->row->getEmail()));
            $user->setPassword(new Password($this->row->getPassword()));
            $user->setRegistrationDate($this->row->getCreationDate());

            $country=null;
            $state=null;
            if ($this->row->getCountry()) {
                /** @var Country $country */
                $country = $countryRepository->getOneBy(['isoalpha3' => $this->row->getCountry()]);
                if ($country->getIsoalpha3() == 'USA') {
                    $state = $stateRepository->getOneBy(['abbrev' => $this->row->getState()]);
                }
            }

            $contact = new UserContactDetails(
                $this->row->getFirstName() ?: '',
                $this->row->getLastName() ?: '',
                $this->row->getZipCode() ?: '',
                $this->row->getAddress() ?: '',
                '',
                $this->row->getPhone() ?: '',
                $country,
                $state
            );

            $user->setContact($contact);

            $em->persist($user);
            $em->flush();
            $em->clear();

            return $user;
    }
}
