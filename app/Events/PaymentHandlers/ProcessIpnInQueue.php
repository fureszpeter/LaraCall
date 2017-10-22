<?php

namespace LaraCall\Events\PaymentHandlers;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use LaraCall\Domain\Entities\PayPalIpnEntity;
use LaraCall\Domain\Factories\PayPalIpnFactory;
use LaraCall\Domain\PayPal\PayPalIpnValidator;
use LaraCall\Domain\Repositories\IpnQueueRepository;
use LaraCall\Domain\Repositories\PayPalIpnRepository;
use LaraCall\Events\IpnStoredToQueueEvent;

class ProcessIpnInQueue implements ShouldQueue
{
    use InteractsWithQueue;

    /** @var IpnQueueRepository */
    private $ipnQueueRepository;

    /** @var PayPalIpnFactory */
    private $ipnFactory;

    /** @var PayPalIpnRepository */
    private $ipnRepository;

    /** @var PayPalIpnValidator */
    private $payPalIpnValidator;

    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * @param PayPalIpnRepository    $ipnRepository
     * @param IpnQueueRepository     $ipnQueueRepository
     * @param PayPalIpnFactory       $ipnFactory
     * @param PayPalIpnValidator     $payPalIpnValidator
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        PayPalIpnRepository $ipnRepository,
        IpnQueueRepository $ipnQueueRepository,
        PayPalIpnFactory $ipnFactory,
        PayPalIpnValidator $payPalIpnValidator,
        EntityManagerInterface $entityManager
    ) {
        $this->ipnQueueRepository = $ipnQueueRepository;
        $this->ipnFactory         = $ipnFactory;
        $this->ipnRepository      = $ipnRepository;
        $this->payPalIpnValidator = $payPalIpnValidator;
        $this->entityManager      = $entityManager;
    }

    public function handle(IpnStoredToQueueEvent $event)
    {
        $ipnQueue = $this->ipnQueueRepository->get($event->getIpnQueueId());

        if ($ipnQueue->getProcessed() instanceof DateTimeInterface)
        {
            return;
        }

        $ipnQueue->increaseTryCount();

        if (null === $ipnQueue->isPayPalTheSender()) {
            $isPayPalTheSender = $this->payPalIpnValidator->isSentByPayPal($ipnQueue->getRawData());
            $ipnQueue->setIsPayPalTheSender($isPayPalTheSender);
            $this->ipnQueueRepository->save($ipnQueue);
        }


        if (false === $ipnQueue->isPayPalTheSender()) {
            $ipnQueue->setProcessed(new DateTimeImmutable());
            $this->ipnQueueRepository->save($ipnQueue);

            return;
        }

        $this->entityManager->transactional(
            function(EntityManagerInterface $em) use ($ipnQueue){
                $ipnQueue->setProcessed(new DateTimeImmutable());
                $em->persist($ipnQueue);

                $ipnVo     = $this->ipnFactory->createFromArray($ipnQueue->getRawData());
                $ipnEntity = new PayPalIpnEntity($ipnVo, $ipnQueue->isPayPalTheSender());
                $em->persist($ipnEntity);
            }
        );
    }
}
