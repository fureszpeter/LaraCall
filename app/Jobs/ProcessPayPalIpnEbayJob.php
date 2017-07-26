<?php

namespace LaraCall\Jobs;

use Illuminate\Events\Dispatcher;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use LaraCall\Domain\PayPal\ValueObjects\PayPalEbayIpn;
use LaraCall\Domain\PayPal\ValueObjects\PayPalIpnEbayTransaction;
use LaraCall\Domain\Repositories\EbayPriceListRepository;
use LaraCall\Domain\Repositories\EbayUserRepository;
use LaraCall\Domain\Repositories\PayPalIpnRepository;
use LaraCall\Domain\Repositories\UserRepository;
use LaraCall\Domain\Services\EbayProcessPaymentService;
use LaraCall\Domain\Services\ImportService;
use LaraCall\Events\BlockedSubscriptionEbayPaymentReceivedEvent;
use LaraCall\Events\ItemNotInPriceListEvent;
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
     * @var EbayUserRepository
     */
    private $ebayUserRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var Dispatcher
     */
    private $eventDispatcher;

    /**
     * @var ImportService
     */
    private $importService;

    /**
     * @var EbayProcessPaymentService
     */
    private $ebayProcessPaymentService;

    /**
     * @var EbayPriceListRepository
     */
    private $priceListRepository;

    /**
     * @var int
     */
    public $tries = 4;

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
     * @param Dispatcher                $eventDispatcher
     * @param UserRepository            $userRepository
     * @param EbayUserRepository        $ebayUserRepository
     * @param PayPalIpnRepository       $payPalIpnRepository
     * @param EbayPriceListRepository   $priceListRepository
     * @param ImportService             $importService
     * @param EbayProcessPaymentService $ebayProcessPaymentService
     *
     * @return void
     */
    public function handle(
        Dispatcher $eventDispatcher,
        UserRepository $userRepository,
        EbayUserRepository $ebayUserRepository,
        PayPalIpnRepository $payPalIpnRepository,
        EbayPriceListRepository $priceListRepository,
        ImportService $importService,
        EbayProcessPaymentService $ebayProcessPaymentService
    ) {
        $this->eventDispatcher           = $eventDispatcher;
        $this->ebayUserRepository        = $ebayUserRepository;
        $this->userRepository            = $userRepository;
        $this->importService             = $importService;
        $this->ebayProcessPaymentService = $ebayProcessPaymentService;
        $this->priceListRepository       = $priceListRepository;

        $payPalIpnEntity = $payPalIpnRepository->get($this->ipnId);
        $payPalEbayIpn   = new PayPalEbayIpn($payPalIpnEntity->getSalesMessage());

        if ($payPalIpnEntity->getEbayUsername() != $payPalEbayIpn->getEbayUserId()) {
            $payPalEbayIpn->setEbayUserId($payPalEbayIpn->getEbayUserId());
        }

        $transactionsExistsInPriceList = $this->getTransactionsExistsInPriceList(
            ...$payPalEbayIpn->getEbayTransactions()
        );

        if (empty($transactionsExistsInPriceList)) {
            return;
        }

        $ebayUserEntity = $this->ebayUserRepository->findByEbayUsername($payPalEbayIpn->getEbayUserId());

        if (
            $ebayUserEntity
            && $ebayUserEntity->getSubscription()->isBlocked()
        ) {
            $this->eventDispatcher->fire(
                new BlockedSubscriptionEbayPaymentReceivedEvent(
                    $ebayUserEntity->getSubscription()->getId(),
                    $ebayUserEntity->getId()
                )
            );

            return;
        }

        $pins = $this->importService->importByEmail($payPalEbayIpn->getPayerEmail());

        if ( ! $pins->isEmpty()) {
            /*
             * This is an existing user
             */
            $user = $this->userRepository->getByEmail($payPalEbayIpn->getPayerEmail());

            $this->ebayProcessPaymentService->addPaymentToSubscription($user->getSubscription(), $payPalIpnEntity);

        } elseif ($ebayUserEntity) {
            /*
             * This is an existing user
             */
            $this->ebayProcessPaymentService->addPaymentToSubscription(
                $ebayUserEntity->getSubscription(),
                $payPalIpnEntity
            );
        } else {
            /*
             * This is a new user
             */
            $subscription = $this->ebayProcessPaymentService->createSubscriptionForIpn($payPalIpnEntity);
            $this->ebayProcessPaymentService->addPaymentToSubscription($subscription, $payPalIpnEntity, true);
        }
    }

    /**
     * @param PayPalIpnEbayTransaction[] ...$payPalIpnEbayTransactions
     *
     * @return PayPalIpnEbayTransaction[]
     */
    private function getTransactionsExistsInPriceList(
        PayPalIpnEbayTransaction ...$payPalIpnEbayTransactions
    ) {
        $filteredTransactions = [];

        foreach ($payPalIpnEbayTransactions as $payPalIpnEbayTransaction) {
            $priceListEntity = $this->priceListRepository->find($payPalIpnEbayTransaction->getItemId()->getItemId());
            if (is_null($priceListEntity)) {
                event(new ItemNotInPriceListEvent(
                        $payPalIpnEbayTransaction->getEbayTxnId(),
                        $payPalIpnEbayTransaction->getItemId()->getItemId())
                );

                Log::info(
                    sprintf(
                        'Transaction not belongs to ebay price list. [transaction id: %s]',
                        $payPalIpnEbayTransaction->getEbayTxnId()
                    )
                );

                continue;
            }

            $filteredTransactions[] = $payPalIpnEbayTransaction;
        }

        return $filteredTransactions;
    }

}
