<?php
namespace LaraCall\Events\PaymentHandlers;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use LaraCall\Domain\Repositories\PayPalIpnRepository;
use LaraCall\Events\PaymentReversedEvent;
use Snowfire\Beautymail\Beautymail;

class SendPaymentReversedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @var PayPalIpnRepository
     */
    private $payPalIpnRepository;

    /**
     * @var Beautymail
     */
    private $beautymail;

    /**
     * @param PayPalIpnRepository $payPalIpnRepository
     * @param Beautymail          $beautymail
     */
    public function __construct(
        PayPalIpnRepository $payPalIpnRepository,
        Beautymail $beautymail
    ) {
        $this->payPalIpnRepository = $payPalIpnRepository;
        $this->beautymail          = $beautymail;
    }

    public function handle(PaymentReversedEvent $event)
    {
        $ipn = $this->payPalIpnRepository->get($event->getIpnId());

        $subscription = $ipn->getSubscription();
        $data         = [
            'subject'      => 'Payment reversed! What should I do now?',
            'name'         => $subscription->getFirstName() . $subscription->getLastName(),
            'email'        => $subscription->getUser()->getEmail(),
            'pins'         => $subscription->getPins()->toArray(),
            'country'      => $subscription->getCountry()->getCountryName(),
            'state'        => $subscription->getState() ? $subscription->getState()->getStateName() : '-',
            'ebayUsername' => $ipn->getParentIpn()->isEbay() ? $ipn->getParentIpn()->getEbayUsername() : '-',
            'amount'       => $ipn->getSalesMessage()->getGrossAmount(),
        ];
        $this->beautymail->send('emails.payment_reversed', $data, function (Message $message) {
            $message
                ->from('info@4call.us')
                ->to(env('EMAIL_ADMIN_EMAIL'), env('EMAIL_ADMIN_NAME'))
                ->subject('Payment reversed!');
        });

    }
}
