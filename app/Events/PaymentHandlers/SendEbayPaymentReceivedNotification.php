<?php

namespace LaraCall\Events\PaymentHandlers;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use LaraCall\Domain\Repositories\EbayPaymentTransactionRepository;
use LaraCall\Events\EbayPaymentCompleteEvent;
use LaraCall\Infrastructure\Services\Ebay\EbayApiService;
use Snowfire\Beautymail\Beautymail;

class SendEbayPaymentReceivedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @var EbayPaymentTransactionRepository
     */
    private $ebayPaymentTransactionRepository;

    /**
     * @var Beautymail
     */
    private $beautyMail;

    /**
     * @var EbayApiService
     */
    private $ebayApiService;

    /**
     * @param EbayPaymentTransactionRepository $paymentTransactionRepository
     * @param EbayApiService                   $ebayApiService
     * @param Beautymail                       $beautyMail
     */
    public function __construct(
        EbayPaymentTransactionRepository $paymentTransactionRepository,
        EbayApiService $ebayApiService,
        Beautymail $beautyMail
    ) {
        $this->ebayPaymentTransactionRepository = $paymentTransactionRepository;
        $this->beautyMail                       = $beautyMail;
        $this->ebayApiService                   = $ebayApiService;
    }

    public function handle(EbayPaymentCompleteEvent $event)
    {
        $ebayPaymentTransaction   = $this->ebayPaymentTransactionRepository->get($event->getEbayPaymentTransactionId());
        $getUserResponse          = $this->ebayApiService->getUser($ebayPaymentTransaction->getEbayUsername());
        $userEbayRegistrationDate = $getUserResponse->User->RegistrationDate;
        $subscription             = $ebayPaymentTransaction->getSubscription();
        $lastPurchases            = $this->ebayPaymentTransactionRepository->getLastRefills($ebayPaymentTransaction);

        $data = [
            'subject'              => 'Ebay Payment complete!',
            'newSubscription'      => $ebayPaymentTransaction->isNewSubscription(),
            'name'                 => $subscription->getFirstName().$subscription->getLastName(),
            'ebayId'               => implode(', ', $subscription->getEbayUsers()->toArray()),
            'email'                => $subscription->getUser()->getEmail(),
            'pin'                  => $subscription->getDefaultPin(),
            'country'              => $subscription->getCountry()->getCountryName(),
            'state'                => $subscription->getState() ? $subscription->getState()->getStateName() : '-',
            'amount'               => $ebayPaymentTransaction->getAmountInUsd(),
            'quantity'             => $ebayPaymentTransaction->getQuantity(),
            'paymentDate'          => $ebayPaymentTransaction->getDatePayment()->format(DATE_ATOM),
            'ebayRegistrationDate' => $userEbayRegistrationDate->format(DATE_ATOM),
            /*
             * Subscription details
             */
            'userCreatedDate'      => $subscription->getUser()->getCreatedAt()->format(DATE_ATOM),
            'pinCount'             => $subscription->getPins()->count(),
            'lastPurchases'        => $lastPurchases,
        ];

        $this->beautyMail->send('emails.payment_complete', $data, function (Message $message) {
            $message
                ->from('info@4call.us')
                ->to(env('EMAIL_ADMIN_EMAIL'), env('EMAIL_ADMIN_NAME'))
                ->subject('Payment complete!');
        });
    }
}
