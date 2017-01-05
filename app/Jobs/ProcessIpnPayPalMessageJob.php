<?php

namespace LaraCall\Jobs;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;
use LaraCall\Domain\Entities\IpnSalesMessageEntity;
use LaraCall\Domain\PayPal\PayPalServiceInterface;
use LaraCall\Domain\PayPal\ValueObjects\IpnSalesMessage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessIpnPayPalMessageJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var IpnSalesMessage
     */
    private $salesMessage;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * Create a new job instance.
     *
     * @param IpnSalesMessage $salesMessage
     */
    public function __construct(IpnSalesMessage $salesMessage)
    {
        $this->salesMessage = $salesMessage;
    }

    /**
     * Execute the job.
     *
     * @param PayPalServiceInterface $payPalService
     * @param EntityManager          $em
     *
     * @return void
     */
    public function handle(PayPalServiceInterface $payPalService, EntityManager $em)
    {

        if ( ! $payPalService->validateIpn($this->salesMessage)) {
            $entity = new IpnSalesMessageEntity($this->salesMessage, false);
            $this->em->persist($entity);
            $this->em->flush();

            echo 'invalid';

            return;
        }

        $entity = new IpnSalesMessageEntity($this->salesMessage, true);
        $this->em->persist($entity);
        $this->em->flush();

        echo 'valid';
    }
}
