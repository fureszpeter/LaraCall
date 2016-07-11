<?php

namespace LaraCall\Console\Commands;

use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Illuminate\Console\Command;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\DB;
use LaraCall\Domain\DTOs\UserImportRowDto;
use LaraCall\Domain\Entities\Subscription;
use LaraCall\Domain\Entities\User;
use LaraCall\Domain\Repositories\UserRepository;
use LaraCall\Domain\Services\UserImportService;
use LaraCall\Domain\ValueObjects\Pin;
use Symfony\Component\Console\Output\OutputInterface;

class ImportUsers extends Command
{
    /**
     * @var ConnectionInterface
     */
    protected $conn;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'a2b:import {--debug}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var array
     */
    private $resetRegistry = [];

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * Create a new command instance.
     *
     * @param UserRepository         $userRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(UserRepository $userRepository, EntityManagerInterface $em)
    {
        parent::__construct();

        $this->conn = DB::connection('a2billing');
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    /**
     * Execute the console command.
     *
     * @param UserImportService $importService
     *
     * @return mixed
     */
    public function handle(UserImportService $importService)
    {
        $result = $this->getImportData();

        foreach ($result as $row) {
            $dto = new UserImportRowDto();
            $dto->setEmail($row->email)
                ->setCreationDate(Carbon::createFromFormat('Y-m-d H:i:s', $row->creationdate))
                ->setPassword($row->uipass)
                ->setLastName($row->lastname)
                ->setFirstName($row->firstname)
                ->setAddress($row->address)
                ->setCity($row->city)
                ->setState($row->state)
                ->setCountry($row->country)
                ->setZipCode($row->zipcode)
                ->setPhone($row->phone)
                ->setPin($row->username)
                ->setExpirationDate(Carbon::createFromFormat('Y-m-d H:i:s', $row->expirationdate));

            try {
                $this->info(sprintf('Handling user. [email: %s]', $dto->getEmail()), OutputInterface::VERBOSITY_DEBUG);

                $user = $importService->processRow($dto);

                $this->info('User saved: ' . $user->getEmail(), OutputInterface::VERBOSITY_VERBOSE);
            } catch (NonUniqueResultException $e) {
                /** @var User $user */
                $user = $this->userRepository->findOneBy(['email' => $dto->getEmail()]);

                if ($this->needReset($dto)) {
                    $user->resetPins();
                    if ($subscription = $user->getSubscription()) {
                        $this->em->remove($subscription);
                        $this->em->flush();
                    }

                    $this->resetRegistry[$dto->getEmail()] = $user;
                } else {
                    if ($subscription = $user->getSubscription()) {
                        $this->em->remove($subscription);
                        $this->em->flush();
                    }
                }

                $subscription = new Subscription($user, new Pin($dto->getPin()));
                $subscription->setExpirationDate($dto->getExpirationDate());
                $subscription->setSubscriptionCreationDate($dto->getCreationDate());

                $this->em->persist($subscription);
                $user->setSubscription($subscription);
                $this->em->flush();
                $this->em->clear();

            } catch (\Exception $e) {
                $this->error(
                    sprintf(
                        'Can not parse row. \n[row: %s] \n[Errpr: %s]',
                        implode(',', (array) $row),
                        $e->getMessage()
                    )
                );
            }
        }
    }

    /**
     * @param UserImportRowDto $dto
     *
     * @return bool
     */
    protected function needReset(UserImportRowDto $dto)
    {
        return ! array_key_exists($dto->getEmail(), $this->resetRegistry);
    }

    /**
     * @return array
     */
    private function getImportData()
    {
        $result = $this->conn->select(
            'SELECT 
                email,
                creationdate,
                uipass,
                lastname,
                firstname,
                address,
                city,
                state,
                country,
                zipcode,
                phone,
                username,
                expirationdate
            FROM
                cc_card
            WHERE'
            . ' email <> \'\' '
//                . ' email = \'arifusa2012@gmail.com\''
            . ' ORDER BY email , creationdate ASC'
        );

        return $result;
    }

    /**
     * @param Pin $pin
     */
    private function setPin(Pin $pin)
    {
        $this->pin = $pin;
    }

}
