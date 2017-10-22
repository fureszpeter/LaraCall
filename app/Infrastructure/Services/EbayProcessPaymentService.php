<?php

namespace LaraCall\Infrastructure\Services;

use A2bApiClient\Api\SubscriptionCreateRequest;
use A2bApiClient\Client;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use LaraCall\Domain\Entities\EbayPaymentTransaction;
use LaraCall\Domain\Entities\PaymentTransaction;
use LaraCall\Domain\Entities\PayPalIpnEntity;
use LaraCall\Domain\Entities\Pin;
use LaraCall\Domain\Entities\Subscription;
use LaraCall\Domain\Entities\User;
use LaraCall\Domain\Factories\PayPalIpnFactory;
use LaraCall\Domain\PayPal\ValueObjects\EbayTransaction;
use LaraCall\Domain\Registration\Services\EbayService;
use LaraCall\Domain\Repositories\CountryRepository;
use LaraCall\Domain\Repositories\EbayPaymentTransactionRepository;
use LaraCall\Domain\Repositories\EbayPriceListRepository;
use LaraCall\Domain\Repositories\EbayUserRepository;
use LaraCall\Domain\Repositories\StateRepository;
use LaraCall\Domain\Services\EbayProcessPaymentService as EbayProcessPaymentServiceInterface;
use LaraCall\Domain\Services\PasswordService;
use LaraCall\Domain\Services\PaymentService;
use LaraCall\Domain\Services\PinGeneratorService;
use LaraCall\Domain\ValueObjects\PaymentSource;
use LaraCall\Events\EbayPaymentCompleteEvent;
use LaraCall\Events\PaymentCompleteEvent;
use LaraCall\Infrastructure\Services\Ebay\EbayApiService;
use LaraCall\Infrastructure\Services\Ebay\ValueObjects\ItemId;
use Log;
use OutOfBoundsException;
use Swap\Swap;

class EbayProcessPaymentService implements EbayProcessPaymentServiceInterface
{
    /**
     * @var EbayPriceListRepository
     */
    private $priceListRepository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var EbayUserRepository
     */
    private $ebayUserRepository;

    /**
     * @var EbayService
     */
    private $ebayService;

    /**
     * @var CountryRepository
     */
    private $countryRepository;

    /**
     * @var StateRepository
     */
    private $stateRepository;

    /**
     * @var EbayPaymentTransactionRepository
     */
    private $ebayPaymentTransactionRepository;

    /**
     * @var PaymentService
     */
    private $paymentService;

    /**
     * @var PasswordService
     */
    private $passwordService;

    /**
     * @var PinGeneratorService
     */
    private $pinGeneratorService;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var EbayApiService
     */
    private $ebayApiService;

    /**
     * @var Swap
     */
    private $swap;
    /** @var PayPalIpnFactory */
    private $ipnFactory;

    /**
     * @param EbayPriceListRepository          $ebayPriceListRepository
     * @param EbayPaymentTransactionRepository $ebayPaymentTransactionRepository
     * @param EntityManagerInterface           $em
     * @param EbayUserRepository               $ebayUserRepository
     * @param CountryRepository                $countryRepository
     * @param StateRepository                  $stateRepository
     * @param EbayService                      $ebayService
     * @param EbayApiService                   $ebayApiService
     * @param PaymentService                   $paymentService
     * @param PasswordService                  $passwordService
     * @param PinGeneratorService              $pinGeneratorService
     * @param Client                           $client
     * @param Swap                             $swap
     * @param PayPalIpnFactory                 $ipnFactory
     */
    public function __construct(
        EbayPriceListRepository $ebayPriceListRepository,
        EbayPaymentTransactionRepository $ebayPaymentTransactionRepository,
        EntityManagerInterface $em,
        EbayUserRepository $ebayUserRepository,
        CountryRepository $countryRepository,
        StateRepository $stateRepository,
        EbayService $ebayService,
        EbayApiService $ebayApiService,
        PaymentService $paymentService,
        PasswordService $passwordService,
        PinGeneratorService $pinGeneratorService,
        Client $client,
        Swap $swap,
        PayPalIpnFactory $ipnFactory
    ) {
        $this->priceListRepository              = $ebayPriceListRepository;
        $this->em                               = $em;
        $this->ebayUserRepository               = $ebayUserRepository;
        $this->ebayService                      = $ebayService;
        $this->countryRepository                = $countryRepository;
        $this->stateRepository                  = $stateRepository;
        $this->ebayPaymentTransactionRepository = $ebayPaymentTransactionRepository;
        $this->paymentService                   = $paymentService;
        $this->passwordService                  = $passwordService;
        $this->pinGeneratorService              = $pinGeneratorService;
        $this->client                           = $client;
        $this->ebayApiService                   = $ebayApiService;
        $this->swap                             = $swap;
        $this->ipnFactory                       = $ipnFactory;
    }

    /**
     * @param Subscription    $subscription
     * @param PayPalIpnEntity $ipn
     * @param bool            $newSubscription
     *
     * @throws Exception
     */
    public function addPaymentToSubscription(
        Subscription $subscription,
        PayPalIpnEntity $ipn,
        bool $newSubscription = false
    ) {
        $ipnVo                 = $this->ipnFactory->createFromIpnEntity($ipn);
        $transactions          = $ipnVo->getEbayTransactions();
        $priceListTransactions = $this->getTransactionsExistsInPriceList(...$transactions);

        $dateOfPurchase = $ipn->getDateOfPayment();
        $ipn->setSubscription($subscription);
        $ebayUser = $this->ebayService->getOrSaveEbayUser($ipn->getEbayUsername(), $subscription);

        foreach ($priceListTransactions as $transaction) {
            $this->em->beginTransaction();
            $subscription->increaseRefill();
            $subscription->setDateLastPurchase($dateOfPurchase);
            $subscription->setLastTransactionAmount($transaction->getAmountPaid());

            $ipn->setProcessedProperties();
            $priceListEntity = $this->priceListRepository->get($transaction->getItemId());
            $quantity        = $transaction->getQuantity();

            if ($priceListEntity->getCurrency() == 'USD') {
                $productValue = $priceListEntity->getProductValue();
            } else {
                $rate         = $this->swap->latest('EUR/USD');
                $productValue = floatval($rate->getValue() * $priceListEntity->getProductValue());
            }

            $creditAdded            = floatval($productValue * $quantity);
            $convertedAmount        = floatval($transaction->getAmountPaid());
            $paymentSource          = new PaymentSource(PaymentSource::SOURCE_EBAY);
            $ebayPaymentTransaction = new EbayPaymentTransaction(
                $newSubscription,
                $dateOfPurchase,
                $ebayUser,
                $transaction->getItemId(),
                $transaction->getEbayTxnId(),
                floatval($priceListEntity->getProductValue()),
                $transaction->getItemName(),
                $transaction->getQuantity(),
                floatval($transaction->getAmountPaid()),
                $transaction->getCurrency(),
                $transaction->getAmountPaid(),
                $ipnVo->getFirstName(),
                $ipnVo->getLastName(),
                $this->countryRepository->getOneBy(['countryCode' => $ipnVo->getCountryCode()]),
                $ipnVo->getZipCode(),
                $ipnVo->getCity(),
                $ipnVo->getAddress(),
                $ipnVo->getPayerEmail(),
                $ipnVo->getReceiverEmail(),
                $ipnVo->getFee(),
                $subscription,
                $this->stateRepository->findOneBy(['stateCode' => $ipnVo->getState()])
            );
            $this->ebayPaymentTransactionRepository->save($ebayPaymentTransaction);

            $paymentTransaction = new PaymentTransaction(
                $subscription->getDefaultPin(),
                $quantity,
                $convertedAmount,
                $transaction->getCurrency(),
                $convertedAmount,
                $creditAdded,
                $paymentSource,
                $dateOfPurchase,
                sprintf('%s-%s', $transaction->getItemId()->getItemId(), $transaction->getEbayTxnId())
            );
            $this->em->persist($paymentTransaction);
            $this->em->flush();

            try {
                $this->paymentService->paymentAddToSubscriptionAccount(
                    $subscription->getDefaultPin(),
                    $dateOfPurchase,
                    $creditAdded,
                    $convertedAmount,
                    $quantity,
                    $paymentSource
                );
                $this->em->commit();
            } catch (Exception $exception) {
                $this->em->rollback();
                throw $exception;
            }
            event(new EbayPaymentCompleteEvent($ebayPaymentTransaction->getId()));
            event(new PaymentCompleteEvent($paymentTransaction->getId()));
        }
    }

    /**
     * @param EbayTransaction[] ...$ebayTransactions
     *
     * @return EbayTransaction[]
     */
    private function getTransactionsExistsInPriceList(
        EbayTransaction ...$ebayTransactions
    ) {
        $filteredTransactions = [];

        foreach ($ebayTransactions as $ebayTransaction) {
            $priceListEntity = $this->priceListRepository->find($ebayTransaction->getItemId()->getItemId());
            if (is_null($priceListEntity)) {
                /**
                 * @TODO Fire event here if needed. (ItemNotInPriceListEvent)
                 */

                Log::info(
                    sprintf(
                        'Transaction not belongs to ebay price list. [transaction id: %s]',
                        $ebayTransaction->getEbayTxnId()
                    )
                );

                continue;
            }

            $filteredTransactions[] = $ebayTransaction;
        }

        return $filteredTransactions;
    }


    /**
     * @param PayPalIpnEntity $ipn
     *
     * @return Subscription
     *
     * @throws OutOfBoundsException If no parsable transaction found in IPN.
     */
    public function createSubscriptionForIpn(PayPalIpnEntity $ipn): Subscription
    {
        $ipnVo                 = $this->ipnFactory->createFromIpnEntity($ipn);
        $transactions          = $ipnVo->getEbayTransactions();
        $priceListTransactions = $this->getTransactionsExistsInPriceList(...$transactions);

        if (empty($priceListTransactions)) {
            throw new OutOfBoundsException(
                sprintf('No parsable transaction found in IPN. [ipn: %s]', $ipn->getId())
            );
        }

        $firstTransaction = current($priceListTransactions);

        $itemId        = new ItemId($firstTransaction->getItemId()->getItemId());
        $transactionId = $firstTransaction->getEbayTxnId();

        $transaction = $this->ebayApiService->getTransaction($itemId, $transactionId);

        $this->em->beginTransaction();

        $password          = $this->passwordService->generate();
        $encryptedPassword = $this->passwordService->encrypt($password);
        $user              = new User($ipnVo->getPayerEmail(), $encryptedPassword);
        $this->em->persist($user);
        $this->em->flush();

        $country   = $this->countryRepository->getByIso2($ipnVo->getCountryCode());
        $firstName = $transaction->Buyer->UserFirstName;
        $lastName  = $transaction->Buyer->UserLastName;
        $zipCode   = $transaction->Buyer->BuyerInfo->ShippingAddress->PostalCode;
        $city      = $transaction->Buyer->BuyerInfo->ShippingAddress->CityName;
        $address1  =
            $transaction->Buyer->BuyerInfo->ShippingAddress->Street1 ?: ''
                                                                        . $transaction->Buyer->BuyerInfo->ShippingAddress->Street2 ?: '';

        $subscription = new Subscription(
            $user,
            $country,
            $firstName,
            $lastName,
            $zipCode,
            $city,
            $address1,
            $this->priceListRepository->get($firstTransaction->getItemId()->getItemId())->getTariffId(),
            null,
            $country->getIsoAlpha3() == 'USA' ? $this->stateRepository->get($ipnVo->getState()) : null,
            $ipnVo->getDateOfTransaction()
        );

        $this->em->persist($subscription);
        $this->em->flush();

        $this->ebayService->getOrSaveEbayUser($ipn->getEbayUsername(), $subscription);

        $pin = new Pin(
            $this->pinGeneratorService->generate(),
            $subscription
        );
        $this->em->persist($pin);
        $subscription->setDefaultPin($pin);
        $this->em->flush();

        $user->setSubscription($subscription);

        try {
            $this->client->getSubscription()->create(new SubscriptionCreateRequest(
                $pin->getPin(),
                $this->pinGeneratorService->alias(),
                $password,
                $subscription->getPackageId(),
                $subscription->getFirstName(),
                $subscription->getLastName(),
                $subscription->getAddress1(),
                $subscription->getCity(),
                $subscription->getCountry()->getIsoAlpha3(),
                $subscription->getZipCode(),
                $subscription->getUser()->getEmail(),
                'USD',
                $subscription->getState() ? $subscription->getState()->getStateCode() : null
            ));
        } catch (Exception $exception) {
            $this->em->rollback();
            throw $exception;
        }

        $this->em->commit();

        return $subscription;
    }
}
