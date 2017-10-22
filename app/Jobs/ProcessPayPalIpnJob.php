<?php

namespace LaraCall\Jobs;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use LaraCall\Domain\Entities\PayPalIpnEntity;
use LaraCall\Domain\Factories\PayPalIpnFactory;
use LaraCall\Domain\Repositories\PayPalIpnRepository;
use LaraCall\Domain\ValueObjects\IpnType;
use LaraCall\Domain\ValueObjects\PaymentStatus;
use LaraCall\Events\PaymentReversalCanceledEvent;
use LaraCall\Events\PaymentReversedEvent;
use LaraCall\Events\PayPalIpnEntityCreatedEvent;
use RuntimeException;
use UnexpectedValueException;

class ProcessPayPalIpnJob extends Job implements ShouldQueue
{
    use InteractsWithQueue;

    /** @var int */
    public $tries = 4;

    /** @var EntityManagerInterface */
    private $em;

    /** @var PayPalIpnRepository */
    private $ipnSalesMessageRepository;

    /** @var Dispatcher */
    private $dispatcher;

    /** @var PayPalIpnFactory */
    private $payPalIpnFactory;

    /**
     * @param EntityManagerInterface $em
     * @param PayPalIpnRepository    $ipnSalesMessageRepository
     * @param Dispatcher             $dispatcher
     * @param PayPalIpnFactory       $payPalIpnFactory
     */
    public function __construct(
        EntityManagerInterface $em,
        PayPalIpnRepository $ipnSalesMessageRepository,
        Dispatcher $dispatcher,
        PayPalIpnFactory $payPalIpnFactory
    ) {
        $this->em                        = $em;
        $this->ipnSalesMessageRepository = $ipnSalesMessageRepository;
        $this->dispatcher                = $dispatcher;
        $this->payPalIpnFactory          = $payPalIpnFactory;
    }

    /**
     * @param PayPalIpnEntityCreatedEvent $event
     */
    public function handle(PayPalIpnEntityCreatedEvent $event)
    {
        $ipnEntity   = $this->ipnSalesMessageRepository->get($event->getIpnId());

        $this->assertIpnIsNotProcessed($ipnEntity);

        $ipnVo         = $this->payPalIpnFactory->createFromIpnEntity($ipnEntity);
        $paymentStatus = $ipnVo->getPaymentStatus();

        switch ($paymentStatus) {
            case PaymentStatus::STATUS_COMPLETED:
                break;
            case PaymentStatus::STATUS_CANCEL_REVERSED:

                event(new PaymentReversalCanceledEvent($ipnEntity->getId()));

                return;

                break;
            case PaymentStatus::STATUS_REVERSED:
                $ipnEntity->setProcessedProperties();
                event(new PaymentReversedEvent($ipnEntity->getId()));

                return;

                break;
            case PaymentStatus::STATUS_PENDING:
//                event(new PaymentPendingEvent($ipnEntity->getTxnId()));

                return;

                break;
            case PaymentStatus::STATUS_FAILED:
//                event(new PaymentFailedEvent($ipnEntity->getTxnId()));

                return;

                break;
            case PaymentStatus::STATUS_REFUNDED:
                $ipnEntity->setProcessedProperties();
//                event(new PaymentRefundedEvent($ipnEntity->getSubscription()->getDefaultPin()->getPin()));

                return;

                break;
        }

        $ipnType = (string)$ipnVo->getIpnType();
        switch ($ipnType) {
            case IpnType::TYPE_PAYPAL_EBAY:
                $this->dispatcher->dispatch(new ProcessPayPalIpnEbayJob($ipnEntity->getId()));

                break;
            case IpnType::TYPE_PAYPAL_WEB:
                $this->dispatcher->dispatch(new ProcessPayPalIpnWebJob($ipnEntity->getId()));

                break;
            default:
                throw new RuntimeException(
                    sprintf('Unknown ipn type. [type: %s]', $ipnType)
                );
        }
    }

    /**
     * @param PayPalIpnEntity $ipnEntity
     *
     * @throws UnexpectedValueException If IPN already processed.
     */
    private function assertIpnIsNotProcessed(PayPalIpnEntity $ipnEntity)
    {
        if ($ipnEntity->getStatus()->isProcessed()) {
            throw new UnexpectedValueException(
                sprintf('Ipn already processed. [id: %s]', $ipnEntity->getTxnId())
            );
        }
    }
}
