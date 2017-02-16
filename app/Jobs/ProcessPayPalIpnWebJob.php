<?php

namespace LaraCall\Jobs;

use Doctrine\ORM\EntityManagerInterface;
use LaraCall\Domain\Repositories\PayPalIpnRepository;
use LaraCall\Domain\Repositories\PinRepository;
use LaraCall\Domain\Services\PaymentService;
use LaraCall\Domain\ValueObjects\PaymentSource;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use OutOfBoundsException;

class ProcessPayPalIpnWebJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var int
     */
    private $ipnId;

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
     * @param PayPalIpnRepository    $payPalIpnRepository
     * @param PinRepository          $pinRepository
     * @param PaymentService         $paymentService
     *
     * @return void
     */
    public function handle(
        EntityManagerInterface $em,
        PayPalIpnRepository $payPalIpnRepository,
        PinRepository $pinRepository,
        PaymentService $paymentService

    ) {
        $payPalIpnEntity = $payPalIpnRepository->get($this->ipnId);
        $ipnMessage      = $payPalIpnEntity->getSalesMessage();

        if ( ! ($pin = $ipnMessage->getCustomField())) {
            Log::info(
                sprintf('No custom field in paypal payment. [txn: %s]', $ipnMessage->getTxnId())
            );
            $payPalIpnEntity->setProcessedProperties();
            $em->flush();

            return;
        }

        try {
            $pinEntity = $pinRepository->get($pin);

        } catch (OutOfBoundsException $exception) {
            Log::error(
                sprintf('Pin not exists in db. [pin: %s]', $pin)
            );
            throw $exception;
        }

        $paymentService->payInTransaction(
            $ipnMessage->getDateOfTransaction(),
            $pinEntity,
            $ipnMessage->getRawPayPalData()['quantity'],
            floatval($ipnMessage->getRawPayPalData()['mc_gross']),
            $ipnMessage->getRawPayPalData()['mc_currency'],
            floatval($ipnMessage->getRawPayPalData()['payment_gross']),
            floatval(
                floatval($ipnMessage->getRawPayPalData()['payment_gross'])
                * intval($ipnMessage->getRawPayPalData()['quantity'])
            ),
            new PaymentSource(PaymentSource::SOURCE_PAYPAL),
            $pin
        );

        $payPalIpnEntity->setProcessedProperties();
        $payPalIpnEntity->setSubscription($pinEntity->getSubscription());
        $em->flush();
    }
}
