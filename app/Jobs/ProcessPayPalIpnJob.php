<?php

namespace LaraCall\Jobs;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use LaraCall\Domain\Entities\PayPalIpn;
use LaraCall\Domain\Repositories\PayPalIpnRepository;
use LaraCall\Domain\Services\PayPalIpnService;
use LaraCall\Domain\ValueObjects\IpnStatus;
use LaraCall\Domain\ValueObjects\IpnType;
use LaraCall\Domain\ValueObjects\PaymentStatus;
use LaraCall\Events\InvalidIpnMessageReceivedEvent;
use LaraCall\Events\PaymentFailedEvent;
use LaraCall\Events\PaymentPendingEvent;
use LaraCall\Events\PaymentRefundedEvent;
use LaraCall\Events\PaymentReversalCanceledEvent;
use LaraCall\Events\PaymentReversedEvent;
use RuntimeException;
use UnexpectedValueException;

class ProcessPayPalIpnJob extends Job implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @var int
     */
    public $tries = 4;

    /**
     * @var int
     */
    private $ipnId;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var PayPalIpnRepository
     */
    private $ipnSalesMessageRepository;

    /**
     * @var PayPalIpnService
     */
    private $payPalIpnService;

    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * Create a new job instance.
     *
     * @param int $ipnId
     */
    public function __construct(int $ipnId)
    {
        $this->ipnId = $ipnId;
    }

    /**
     * Execute the job.
     *
     * @param EntityManagerInterface $em
     * @param PayPalIpnRepository    $ipnSalesMessageRepository
     * @param PayPalIpnService       $payPalIpnService
     * @param Dispatcher             $dispatcher
     *
     * @return void
     */
    public function handle(
        EntityManagerInterface $em,
        PayPalIpnRepository $ipnSalesMessageRepository,
        PayPalIpnService $payPalIpnService,
        Dispatcher $dispatcher
    ) {
        $this->em                        = $em;
        $this->ipnSalesMessageRepository = $ipnSalesMessageRepository;
        $this->payPalIpnService          = $payPalIpnService;
        $this->dispatcher                = $dispatcher;

        $ipnEntity = $ipnSalesMessageRepository->get($this->ipnId);

        $this->assertIpnIsNotProcessed($ipnEntity);

        Log::info(sprintf('Job started. [name: %s]', self::class));

        if (false === $this->assertIpnValid($ipnEntity)) {
            Log::info(
                sprintf(
                    'Invalid ipn received. [ipn id: %s; email: %s]',
                    $ipnEntity->getId(),
                    $ipnEntity->getSalesMessage()->getPayerEmail()
                )
            );

            event(new InvalidIpnMessageReceivedEvent($ipnEntity->getSalesMessage()));

            return;
        }

        switch ($this->payPalIpnService->getPaymentStatus($ipnEntity->getSalesMessage())) {
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
                event(new PaymentPendingEvent($ipnEntity->getTxnId()));

                return;

                break;
            case PaymentStatus::STATUS_FAILED:
                event(new PaymentFailedEvent($ipnEntity->getTxnId()));

                return;

                break;
            case PaymentStatus::STATUS_REFUNDED:
                $ipnEntity->setProcessedProperties();
                event(new PaymentRefundedEvent($ipnEntity->getSubscription()->getDefaultPin()->getPin()));

                return;

                break;
        }

        $ipnType = $payPalIpnService->getIpnType($ipnEntity->getSalesMessage());

        switch ($ipnType) {
            case IpnType::TYPE_PAYPAL_EBAY:
                $dispatcher->dispatch(new ProcessPayPalIpnEbayJob($ipnEntity->getId()));

                break;
            case IpnType::TYPE_PAYPAL_WEB:
                $dispatcher->dispatch(new ProcessPayPalIpnWebJob($ipnEntity->getId()));

                break;
            default:
                throw new RuntimeException(
                    sprintf('Unknown ipn type. [type: %s]', $ipnType)
                );
        }
    }

    /**
     * @param PayPalIpn $ipnEntity
     *
     * @throws UnexpectedValueException If IPN already processed.
     */
    private function assertIpnIsNotProcessed(PayPalIpn $ipnEntity)
    {
        if ($ipnEntity->getStatus()->isProcessed()) {
            throw new UnexpectedValueException(
                sprintf('Ipn already processed. [id: %s]', $ipnEntity->getTxnId())
            );
        }
    }

    /**
     * @param PayPalIpn $ipnEntity
     *
     * @return bool
     */
    private function assertIpnValid(PayPalIpn $ipnEntity): bool
    {
        if (!$this->payPalIpnService->isValid($ipnEntity)) {
            $ipnEntity->setProcessedProperties();
            $ipnEntity->setStatus(new IpnStatus(IpnStatus::STATUS_PROCESSED));

            $this->em->flush();

            return false;
        }

        return true;
    }
}
