<?php
namespace LaraCall\Domain\Services;

use A2bApiClient\Client;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use LaraCall\Domain\Entities\Pin;
use LaraCall\Domain\Entities\PaymentTransaction;
use LaraCall\Domain\ValueObjects\PaymentSource;
use LaraCall\Events\PaymentCompleteEvent;

/**
 * Class PaymentService.
 *
 * @package LaraCall
 *
 * @license Proprietary
 */
class PaymentService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var Client
     */
    private $client;

    /**
     * @param EntityManagerInterface $em
     * @param Client                 $client
     */
    public function __construct(EntityManagerInterface $em, Client $client)
    {
        $this->em     = $em;
        $this->client = $client;
    }

    /**
     * @param DateTimeInterface $dateOfPayment
     * @param Pin               $pinEntity
     * @param int               $quantity
     * @param float             $amountPayed
     * @param string            $currency
     * @param float             $convertedAmount
     * @param float             $creditAdded
     * @param PaymentSource     $paymentSource
     * @param string|null       $remoteTransactionId The remote transaction id.
     *                                               For example if it is an eBay transaction, the itemId-TransactionId
     *
     * @return bool
     * @throws Exception
     */
    public function payInTransaction(
        DateTimeInterface $dateOfPayment,
        Pin $pinEntity,
        int $quantity,
        float $amountPayed,
        string $currency,
        float $convertedAmount,
        float $creditAdded,
        PaymentSource $paymentSource,
        string $remoteTransactionId = null

    ): bool {
        $this->em->beginTransaction();

        try {
            $paymentTransaction = $this->paymentDb(
                $dateOfPayment,
                $pinEntity,
                $quantity,
                $amountPayed,
                $currency,
                $convertedAmount,
                $creditAdded,
                $paymentSource,
                $remoteTransactionId
            );

            $this->paymentAddToSubscriptionAccount(
                $pinEntity,
                $dateOfPayment,
                $creditAdded,
                $amountPayed,
                $quantity,
                $paymentSource
            );

            $this->em->commit();

        } catch (Exception $exception) {
            $this->em->rollback();

            throw $exception;
        }

        event(new PaymentCompleteEvent($paymentTransaction->getId()));

        return true;
    }

    /**
     * @param DateTimeInterface $dateOfPayment
     * @param Pin               $pin
     * @param int               $quantity
     * @param float             $amountPayed
     * @param string            $currency
     * @param float             $convertedAmount
     * @param float             $creditAdded
     * @param PaymentSource     $paymentSource
     * @param string|null       $remoteTransactionId
     *
     * @return PaymentTransaction
     */
    public function paymentDb(
        DateTimeInterface $dateOfPayment,
        Pin $pin,
        int $quantity,
        float $amountPayed,
        string $currency,
        float $convertedAmount,
        float $creditAdded,
        PaymentSource $paymentSource,
        string $remoteTransactionId = null
    ): PaymentTransaction {
        $paymentTransaction = new PaymentTransaction(
            $pin,
            $quantity,
            $amountPayed,
            $currency,
            $convertedAmount,
            $creditAdded,
            $paymentSource,
            $dateOfPayment,
            $remoteTransactionId
        );
        $this->em->persist($paymentTransaction);
        $this->em->flush();

        return $paymentTransaction;
    }

    /**
     * @param Pin               $pinEntity
     * @param DateTimeInterface $dateOfPayment
     * @param float             $creditToAdd
     * @param float             $amountPayed
     * @param int               $quantity
     * @param PaymentSource     $paymentSource
     */
    public function paymentAddToSubscriptionAccount(
        Pin $pinEntity,
        DateTimeInterface $dateOfPayment,
        float $creditToAdd,
        float $amountPayed,
        int $quantity,
        PaymentSource $paymentSource
    ) {
        $subscriptionInstance = $this->client->getSubscription()->getByPin(
            $pinEntity->getPin()
        );

        $this->client->getPayment($subscriptionInstance->id)->create(
            $creditToAdd,
            $amountPayed,
            $quantity,
            $paymentSource,
            $dateOfPayment
        );
    }
}
