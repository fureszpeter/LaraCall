<?php
namespace LaraCall\Events\PaymentHandlers;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use LaraCall\Domain\Repositories\PaymentTransactionRepository;
use LaraCall\Events\PaymentCompleteEvent;
use Snowfire\Beautymail\Beautymail;

class SendPaymentReceivedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @var PaymentTransactionRepository
     */
    private $paymentTransactionRepository;

    /**
     * @var Beautymail
     */
    private $beautyMail;

    /**
     * @param PaymentTransactionRepository $paymentTransactionRepository
     * @param Beautymail                   $beautyMail
     */
    public function __construct(
        PaymentTransactionRepository $paymentTransactionRepository,
        Beautymail $beautyMail
    ) {
        $this->paymentTransactionRepository = $paymentTransactionRepository;
        $this->beautyMail                   = $beautyMail;
    }

    public function handle(PaymentCompleteEvent $event)
    {
        $paymentTransaction = $this->paymentTransactionRepository->get($event->getPaymentTransactionId());
        $subscription       = $paymentTransaction->getPin()->getSubscription();
        $lastPurchases      = $this->paymentTransactionRepository->findBySubscription($subscription);

        $data = [
            'subject'       => 'Payment complete!',
            'name'          => $subscription->getFirstName() . $subscription->getLastName(),
            'ebayId'        => implode(', ', $subscription->getEbayUsers()->toArray()),
            'email'         => $subscription->getUser()->getEmail(),
            'pin'           => $subscription->getDefaultPin(),
            'country'       => $subscription->getCountry()->getCountryName(),
            'state'         => $subscription->getState() ? $subscription->getState()->getStateName() : '-',
            'amount'        => $paymentTransaction->getConvertedAmount(),
            'quantity'      => $paymentTransaction->getQuantity(),
            'date'          => $paymentTransaction->getDateOfPayment()->format(DATE_ATOM),
            /*
             * Subscription details
             */
            'regDate'       => $subscription->getCreatedAt()->format(DATE_ATOM),
            'pinCount'      => $subscription->getPins()->count(),
            'lastPurchases' => $lastPurchases,
        ];

        $this->beautyMail->send('emails.payment_complete', $data, function (Message $message) {
            $message
                ->from('info@4call.us')
                ->to(env('EMAIL_ADMIN_EMAIL'), env('EMAIL_ADMIN_NAME'))
                ->subject('Payment complete!');
        });

    }
}
