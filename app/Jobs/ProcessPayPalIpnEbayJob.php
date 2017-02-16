<?php

namespace LaraCall\Jobs;

use A2bApiClient\Api\SubscriptionCreateRequest;
use A2bApiClient\Client;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use LaraCall\Domain\Entities\EbayUser;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use LaraCall\Domain\Entities\PaymentTransaction;
use LaraCall\Domain\Entities\Pin;
use LaraCall\Domain\Entities\Subscription;
use LaraCall\Domain\Entities\User;
use LaraCall\Domain\PayPal\ValueObjects\EbayIpnSalesMessage;
use LaraCall\Domain\PayPal\ValueObjects\PayPalIpnEbayTransactionDetails;
use LaraCall\Domain\Repositories\CountryRepository;
use LaraCall\Domain\Repositories\EbayPriceListRepository;
use LaraCall\Domain\Repositories\EbayUserRepository;
use LaraCall\Domain\Repositories\PayPalIpnRepository;
use LaraCall\Domain\Repositories\StateRepository;
use LaraCall\Domain\Repositories\UserRepository;
use LaraCall\Domain\Services\EbayUsernameTokenResolver;
use LaraCall\Domain\Services\PasswordService;
use LaraCall\Domain\Services\PaymentService;
use LaraCall\Domain\Services\PayPalIpnAddressResolver;
use LaraCall\Domain\Services\PinGeneratorService;
use LaraCall\Domain\ValueObjects\PaymentSource;
use LaraCall\Events\BlockedSubscriptionEbayPaymentReceivedEvent;
use LaraCall\Events\ItemNotInPriceListEvent;
use LaraCall\Events\PaymentCompleteEvent;
use LaraCall\Infrastructure\Services\Ebay\EbayApiService;
use Log;

/**
 * Class ProcessPayPalIpnEbayJob.
 *
 * @package LaraCall
 *
 * @license Proprietary
 */
class ProcessPayPalIpnEbayJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var int
     */
    private $ipnId;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var EbayApiService
     */
    private $ebayApiService;

    /**
     * @var EbayUserRepository
     */
    private $ebayUserRepository;

    /**
     * @var EbayPriceListRepository
     */
    private $ebayPriceListRepository;

    /**
     * @var CountryRepository
     */
    private $countryRepository;

    /**
     * @var StateRepository
     */
    private $stateRepository;

    /**
     * @var PinGeneratorService
     */
    private $pinGeneratorService;

    /**
     * @var PasswordService
     */
    private $passwordService;

    /**
     * @var PayPalIpnRepository
     */
    private $payPalIpnRepository;

    /**
     * @var EbayUsernameTokenResolver
     */
    private $usernameTokenResolver;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var PayPalIpnAddressResolver
     */
    private $addressResolver;

    /**
     * @var PaymentService
     */
    private $paymentService;

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
     * @param EntityManagerInterface    $em
     * @param Client                    $client
     * @param EbayApiService            $ebayApiService
     * @param UserRepository            $userRepository
     * @param EbayUserRepository        $ebayUserRepository
     * @param EbayPriceListRepository   $ebayPriceListRepository
     * @param CountryRepository         $countryRepository
     * @param StateRepository           $stateRepository
     * @param PinGeneratorService       $pinGeneratorService
     * @param PasswordService           $passwordService
     * @param PayPalIpnRepository       $payPalIpnRepository
     * @param EbayUsernameTokenResolver $usernameTokenResolver
     * @param PayPalIpnAddressResolver  $addressResolver
     * @param PaymentService            $paymentService
     *
     * @return void
     *
     * @throws Exception
     */
    public function handle(
        EntityManagerInterface $em,
        Client $client,
        EbayApiService $ebayApiService,
        UserRepository $userRepository,
        EbayUserRepository $ebayUserRepository,
        EbayPriceListRepository $ebayPriceListRepository,
        CountryRepository $countryRepository,
        StateRepository $stateRepository,
        PinGeneratorService $pinGeneratorService,
        PasswordService $passwordService,
        PayPalIpnRepository $payPalIpnRepository,
        EbayUsernameTokenResolver $usernameTokenResolver,
        PayPalIpnAddressResolver $addressResolver,
        PaymentService $paymentService
    ) {
        $this->em                      = $em;
        $this->client                  = $client;
        $this->ebayApiService          = $ebayApiService;
        $this->ebayUserRepository      = $ebayUserRepository;
        $this->ebayPriceListRepository = $ebayPriceListRepository;
        $this->countryRepository       = $countryRepository;
        $this->stateRepository         = $stateRepository;
        $this->pinGeneratorService     = $pinGeneratorService;
        $this->passwordService         = $passwordService;
        $this->payPalIpnRepository     = $payPalIpnRepository;
        $this->usernameTokenResolver   = $usernameTokenResolver;
        $this->userRepository          = $userRepository;
        $this->addressResolver         = $addressResolver;
        $this->paymentService          = $paymentService;

        $payPalIpnEntity           = $payPalIpnRepository->get($this->ipnId);
        $payPalEbayIpnSalesMessage = new EbayIpnSalesMessage($payPalIpnEntity->getSalesMessage());

        $transactionsExistsInPriceList = $this->getTransactionsExistsInPriceList(
            ...$payPalEbayIpnSalesMessage->getTransactions()
        );
        $firstTransaction              = current($transactionsExistsInPriceList);

        if (empty($transactionsExistsInPriceList)) {
            return;
        }

        $ebayUserEntity = $this->getOrSaveEbayUser($payPalEbayIpnSalesMessage);

        if ($ebayUserEntity->getSubscription() && $ebayUserEntity->getSubscription()->isBlocked()) {
            event(
                new BlockedSubscriptionEbayPaymentReceivedEvent(
                    $ebayUserEntity->getSubscription()->getId(),
                    $ebayUserEntity->getId()
                )
            );

            return;
        }

        $user = $this->userRepository->findOneBy(['email' => $payPalEbayIpnSalesMessage->getPayerEmail()]);
        if ( ! $user) {
            $password = $this->passwordService->generate();
            $user     = new User(
                $payPalEbayIpnSalesMessage->getPayerEmail(),
                $this->passwordService->encrypt($password)
            );
            $this->em->persist($user);
            $this->em->flush();
        }

        $this->em->beginTransaction();
        $subscription = $user->getSubscription();

        if ( ! $subscription) {
            $address      = $this->addressResolver->resolve($payPalEbayIpnSalesMessage->getRawPayPalData());
            $subscription = new Subscription(
                $user,
                $address->getCountryEntity(),
                $address->getFirstName(),
                $address->getLastName(),
                $address->getZipCode(),
                $address->getCity(),
                $address->getAddress1(),
                $this->ebayPriceListRepository->get($firstTransaction->getItemId()->getItemId())->getTariffId(),
                $address->getAddress2(),
                $address->getStateEntity(),
                new DateTime()
            );
            $this->em->persist($subscription);
            $user->setSubscription($subscription);
            $ebayUserEntity->setSubscription($subscription);
            $this->em->flush();
        }

        if ( ! $ebayUserEntity->getSubscription()) {
            $ebayUserEntity->setSubscription($subscription);
            $this->em->flush();
        }

        $pin = $subscription->getDefaultPin();

        if ( ! $pin) {
            $pin = new Pin($this->pinGeneratorService->generate(), $subscription);
            $this->em->persist($pin);
            $subscription->setDefaultPin($pin);

            try {
                $this->client->getSubscription()->create(new SubscriptionCreateRequest(
                    $pin->getPin(),
                    $this->pinGeneratorService->alias(),
                    isset($password) ? $password : $this->passwordService->generate(),
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
                $this->em->flush();
            } catch (Exception $exception) {
                $this->em->rollback();
                throw new $exception;
            }
        }
        $this->em->commit();

        foreach ($transactionsExistsInPriceList as $transactionDetails) {
            $this->em->beginTransaction();

            $dateOfPurchase = $payPalEbayIpnSalesMessage->getDateOfTransaction();

            $transactionType = $this->ebayApiService->getTransaction(
                $transactionDetails->getItemId(),
                $transactionDetails->getTxnId()
            );

            $priceListEntity = $this->ebayPriceListRepository->get($transactionDetails->getItemId()->getItemId());

            $ebayUserEntity->setDateLastPurchase($dateOfPurchase);
            $payPalIpnEntity->setSubscription($subscription);
            $payPalIpnEntity->setProcessedProperties();

            $creditAdded     = floatval(floatval($priceListEntity->getProductValue()) * $transactionType->QuantityPurchased);
            $convertedAmount = $transactionType->ConvertedAmountPaid->value;
            $quantity        = $transactionType->QuantityPurchased;
            $paymentSource   = new PaymentSource(PaymentSource::SOURCE_EBAY);

            $paymentTransaction = new PaymentTransaction(
                $pin,
                $quantity,
                $transactionType->AmountPaid->value,
                $transactionType->AmountPaid->currencyID,
                $convertedAmount,
                $creditAdded,
                $paymentSource,
                $dateOfPurchase,
                sprintf('%s-%s', $transactionDetails->getItemId()->getItemId(), $transactionDetails->getTxnId())
            );
            $this->em->persist($paymentTransaction);
            $this->em->flush();

            try {
                $this->paymentService->paymentAddToSubscriptionAccount(
                    $pin,
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
            event(new PaymentCompleteEvent($paymentTransaction->getId()));
        }
        $payPalIpnEntity->setProcessedProperties();
        $this->em->flush();
    }

    /**
     * @param PayPalIpnEbayTransactionDetails[] ...$transactionDetailsArray
     *
     * @return PayPalIpnEbayTransactionDetails[]
     */
    private function getTransactionsExistsInPriceList(PayPalIpnEbayTransactionDetails ...$transactionDetailsArray
    ): array {
        $filteredTransactions = [];

        foreach ($transactionDetailsArray as $transactionDetails) {
            $priceListEntity = $this->ebayPriceListRepository->find($transactionDetails->getItemId()->getItemId());
            if (is_null($priceListEntity)) {
                event(new ItemNotInPriceListEvent(
                        $transactionDetails->getTxnId(),
                        $transactionDetails->getItemId()->getItemId())
                );

                Log::info(
                    sprintf(
                        'Transaction not belongs to ebay price list. [transaction id: %s]',
                        $transactionDetails->getTxnId()
                    )
                );

                continue;
            }

            $filteredTransactions[] = $transactionDetails;
        }

        return $filteredTransactions;
    }

    /**
     * @param EbayIpnSalesMessage $ipnSalesMessage
     *
     * @return EbayUser
     *
     */
    private function getOrSaveEbayUser(EbayIpnSalesMessage $ipnSalesMessage): EbayUser
    {
        $ebayUsername = $ipnSalesMessage->getEbayUserId();

        $ebayUser = $this->ebayUserRepository->findOneBy(['ebayUserId' => $ebayUsername]);

        if ( ! $ebayUser) {
            $token    = $this->ebayApiService->getUser($ebayUsername)->User->EIASToken;
            $ebayUser = new EbayUser(
                $token,
                $ebayUsername,
                $ipnSalesMessage->getPayerEmail(),
                new DateTime()
            );
            $this->em->persist($ebayUser);
            $this->em->flush();
        }

        return $ebayUser;
    }
}
