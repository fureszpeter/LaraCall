<?php

namespace LaraCall\Console\Commands;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Console\Command;
use LaraCall\Domain\Entities\Delivery;
use LaraCall\Domain\Repositories\PinRepository;
use LaraCall\Domain\Services\DeliveryTokenGenerator;

class GenerateDeliveryTokenCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delivery:generate {pin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate delivery token for pin.';

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
     * @param PinRepository          $pinRepository
     * @param DeliveryTokenGenerator $tokenGenerator
     *
     * @return mixed
     */
    public function handle(
        EntityManagerInterface $em,
        PinRepository $pinRepository,
        DeliveryTokenGenerator $tokenGenerator
    ) {
        $pin  = $pinRepository->get($this->argument('pin'));
        $token = $tokenGenerator->generate();

        $deliveryEntity = new Delivery($token, $pin);
        $em->persist($deliveryEntity);
        $em->flush();
    }
}
