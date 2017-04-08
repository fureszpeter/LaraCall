<?php

namespace LaraCall\Events\PaymentHandlers;

use A2bApiClient\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use LaraCall\Domain\Entities\EbayPaymentTransaction;
use LaraCall\Domain\Repositories\PayPalIpnRepository;
use LaraCall\Events\PaymentReversedEvent;
use LaraCall\Infrastructure\Services\Ebay\EbayApiService;
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
     * @var Client
     */
    private $a2bClient;

    /**
     * @var EbayApiService
     */
    private $ebayApiService;

    /**
     * @param PayPalIpnRepository $payPalIpnRepository
     * @param Beautymail          $beautymail
     * @param Client              $a2bClient
     * @param EbayApiService      $ebayApiService
     */
    public function __construct(
        PayPalIpnRepository $payPalIpnRepository,
        Beautymail $beautymail,
        Client $a2bClient,
        EbayApiService $ebayApiService
    ) {
        $this->payPalIpnRepository = $payPalIpnRepository;
        $this->beautymail          = $beautymail;
        $this->a2bClient           = $a2bClient;
        $this->ebayApiService      = $ebayApiService;
    }

    public function handle(PaymentReversedEvent $event)
    {
        $ipn = $this->payPalIpnRepository->get($event->getIpnId());
        if ( ! $ipn->isEbay()) {
            return;
        }

        $subscription = $ipn->getParentIpn()->getSubscription();

        /** @var EbayPaymentTransaction $ebayTransaction */
        $ebayTransaction          = $subscription->getEbayPayments()->first();
        $getUserResponse          = $this->ebayApiService->getUser($ebayTransaction->getEbayUsername());
        $userEbayRegistrationDate = $getUserResponse->User->RegistrationDate;


        $apiSubscription = $this->a2bClient->getSubscription()->getByPin($subscription->getDefaultPin()->getPin());
        $apiSubscription->credit;
        $data = [
            'subject'  => 'Payment reversed! What should I do now?',
            'credit'   => $apiSubscription->credit,
            'lastUsed' => $apiSubscription->lastuse,
            'pinCount' => $subscription->getPins()->count(),
            'ebayRegistrationDate' => $userEbayRegistrationDate->format(DATE_ATOM),

            'name'         => $subscription->getFirstName().$subscription->getLastName(),
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
