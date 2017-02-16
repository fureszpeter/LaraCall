<?php
namespace LaraCall\Events\PaymentHandlers;

use DTS\eBaySDK\Trading\Enums\MessageTypeCodeType;
use DTS\eBaySDK\Trading\Enums\QuestionTypeCodeType;
use DTS\eBaySDK\Trading\Types\MemberMessageType;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use LaraCall\Domain\Repositories\PaymentTransactionRepository;
use LaraCall\Events\PaymentCompleteEvent;
use LaraCall\Infrastructure\Services\Ebay\EbayApiService;

class DoEbayPostJobs implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @var PaymentTransactionRepository
     */
    private $paymentTransactionRepository;

    /**
     * @var EbayApiService
     */
    private $ebayApiService;

    /**
     * @param PaymentTransactionRepository $paymentTransactionRepository
     * @param EbayApiService               $ebayApiService
     */
    public function __construct(
        PaymentTransactionRepository $paymentTransactionRepository,
        EbayApiService $ebayApiService
    ) {
        $this->paymentTransactionRepository = $paymentTransactionRepository;
        $this->ebayApiService = $ebayApiService;
    }

    public function handle(PaymentCompleteEvent $event)
    {
        $paymentTransaction = $this->paymentTransactionRepository->get($event->getPaymentTransactionId());
        if ( ! $paymentTransaction->getSource()->isEbay()) {
            return;
        }

        $ebayIds       = explode('-', $paymentTransaction->getRemoteTransactionId());
        $itemId        = $ebayIds[0];
        $transactionId = $ebayIds[1];

        $this->ebayApiService->markItemShipped($itemId, $transactionId);

        $message = sprintf(
            "Your high quality calling card is ready to use.\r\n"
            . "We sent you the details to your paypal email too.\r\n"
            . "\r\n"
            . "\r\n"
            . "Card PIN: %s\r\n"
            . "Balance added: %s x $%s USD\r\n"
            . "\r\n"
            . "Access numbers:\r\n"
            . "\r\n"
            . "From private phone:\r\n"
            . "-(USA, Los Angeles, CA): +1(213)232-0250\r\n"
            . "-(USA, NY): +1(914)226-2560\r\n"
            . "-(USA, Chicago, IL): +1(773)439-1173\r\n"
            . "-(Canada, Toronto, ON): +1(647)558-4860\r\n"
            . "-(IT, Rome): +39(06)9480-4403\r\n"
            . "From public phone:\r\n"
            . "-(USA, Seattle, WA): +1 (206)279-5109\r\n"
            . "TOLL FREE (USA): +1(844)637-4229\r\n"
            . "\r\n"
            . "IMPORTANT! Please note, our rates are based on local access number usage. "
            . "When you use our service by the TOLL FREE access, additional $0.03 USD / min applied to our standard rates. "
            . "PLEASE CHECK YOUR EMAIL ABOUT THE DETAILS!\r\n"
            . "\r\n"
            . "Thank you for using our services!\r\n"
            . "Please do not forget to send a positive feedback if you are satisfied\r\n"
            . "with our fast shipping and high quality services.\r\n"
            . "www.4call.us",
            $paymentTransaction->getPin()->getPin(),
            $paymentTransaction->getQuantity(),
            round($paymentTransaction->getRefillValue(), 2)
        );

        $memberMessageType               = new MemberMessageType();
        $memberMessageType->Subject      = "Calling card shipped";
        $memberMessageType->Body         = $message;
        $memberMessageType->MessageType  = MessageTypeCodeType::C_CONTACT_EBAY_MEMBER;
        $memberMessageType->RecipientID  = [$paymentTransaction->getPin()->getSubscription()->getEbayUsers()->last()];
        $memberMessageType->QuestionType = QuestionTypeCodeType::C_SHIPPING;

        $this->ebayService->sendMessageToBuyer($itemId, $memberMessageType);


    }
}
