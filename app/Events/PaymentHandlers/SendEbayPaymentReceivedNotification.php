<?php
namespace LaraCall\Events\PaymentHandlers;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use LaraCall\Domain\Repositories\EbayPaymentTransactionRepository;
use LaraCall\Events\EbayPaymentCompleteEvent;
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
     * @param EbayPaymentTransactionRepository $paymentTransactionRepository
     * @param Beautymail                       $beautyMail
     */
    public function __construct(
        EbayPaymentTransactionRepository $paymentTransactionRepository,
        Beautymail $beautyMail
    ) {
        $this->ebayPaymentTransactionRepository = $paymentTransactionRepository;
        $this->beautyMail                       = $beautyMail;
    }

    public function handle(EbayPaymentCompleteEvent $event)
    {
        $ebayPaymentTransaction = $this->ebayPaymentTransactionRepository->get($event->getEbayPaymentTransactionId());
        $subscription           = $ebayPaymentTransaction->getSubscription();
        $lastPurchases          = $this->ebayPaymentTransactionRepository->getLastRefills($ebayPaymentTransaction);

        $data = [
            'subject'         => 'Ebay Payment complete!',
            'newSubscription' => $ebayPaymentTransaction->isNewSubscription(),
            'name'            => $subscription->getFirstName() . $subscription->getLastName(),
            'ebayId'          => implode(', ', $subscription->getEbayUsers()->toArray()),
            'email'           => $subscription->getUser()->getEmail(),
            'pin'             => $subscription->getDefaultPin(),
            'country'         => $subscription->getCountry()->getCountryName(),
            'state'           => $subscription->getState() ? $subscription->getState()->getStateName() : '-',
            'amount'          => $ebayPaymentTransaction->getAmountInUsd(),
            'quantity'        => $ebayPaymentTransaction->getQuantity(),
            'date'            => $ebayPaymentTransaction->getDatePayment()->format(DATE_ATOM),
            /*
             * Subscription details
             */
            'regDate'         => $subscription->getUser()->getCreatedAt()->format(DATE_ATOM),
            'pinCount'        => $subscription->getPins()->count(),
            'lastPurchases'   => $lastPurchases,
        ];

        $this->beautyMail->send('emails.payment_complete', $data, function (Message $message) {
            $message
                ->from('info@4call.us')
                ->to(env('EMAIL_ADMIN_EMAIL'), env('EMAIL_ADMIN_NAME'))
                ->subject('Payment complete!');
        });
    }
}
