<?php
namespace LaraCall\Events\PaymentHandlers;

use DTS\eBaySDK\Trading\Enums\MessageTypeCodeType;
use DTS\eBaySDK\Trading\Enums\QuestionTypeCodeType;
use DTS\eBaySDK\Trading\Types\MemberMessageType;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use LaraCall\Domain\Entities\EbayPaymentTransaction;
use LaraCall\Domain\Repositories\EbayPaymentTransactionRepository;
use LaraCall\Events\EbayPaymentCompleteEvent;
use LaraCall\Infrastructure\Services\Ebay\EbayApiService;

class DoEbayPostJobs implements ShouldQueue
{
    use InteractsWithQueue;

    const EOL = PHP_EOL;

    /**
     * @var EbayPaymentTransactionRepository
     */
    private $repository;

    /**
     * @var EbayApiService
     */
    private $apiService;

    /**
     * @var EbayPaymentTransaction
     */
    private $transaction;

    /**
     * @param EbayPaymentTransactionRepository $repository
     * @param EbayApiService                   $apiService
     */
    public function __construct(
        EbayPaymentTransactionRepository $repository,
        EbayApiService $apiService
    ) {
        $this->repository = $repository;
        $this->apiService = $apiService;
    }

    public function handle(EbayPaymentCompleteEvent $event)
    {
        $transaction = $this->repository->get($event->getEbayPaymentTransactionId());

        $this->transaction = $transaction;
        $transactionId     = $transaction->getTransactionId();
        $itemId            = $transaction->getItemId()->getItemId();

        $this->apiService->markItemShipped($itemId, $transactionId);
        $this->sendEbayMessage($transaction, $itemId);
    }

    /**
     * @param EbayPaymentTransaction $transaction
     * @param string                 $itemId
     */
    public function sendEbayMessage(EbayPaymentTransaction $transaction, string $itemId)
    {
        $message = ($transaction->isNewSubscription())
            ? $this->getNewSubscriptionMessage()
            : $this->getCreditAddedMessage();


        $memberMessageType               = new MemberMessageType();
        $memberMessageType->Subject      = "Calling card shipped";
        $memberMessageType->Body         = $message;
        $memberMessageType->MessageType  = MessageTypeCodeType::C_CONTACT_EBAY_MEMBER;
        $memberMessageType->RecipientID  = [$transaction->getEbayUser()->getEbayUserId()];
        $memberMessageType->QuestionType = QuestionTypeCodeType::C_SHIPPING;

        $this->apiService->sendMessageToBuyer($itemId, $memberMessageType);
    }

    /**
     * @return string
     */
    private function getNewSubscriptionMessage(): string
    {
        $message = sprintf(
            "Your high quality calling card is ready to use. " . self::EOL
            . "We sent you the details to your PayPal email too." . self::EOL
            . self::EOL
            . self::EOL
            . "Card PIN: %s" . self::EOL
            . "Balance added: %s x $%s USD" . self::EOL
            . self::EOL
            . "Access numbers:" . self::EOL
            . self::EOL
            . "From private phone:" . self::EOL
            . "-(USA, Los Angeles, CA): +1(213)232-0250" . self::EOL
            . "-(USA, NY): +1(914)226-2560" . self::EOL
            . "-(USA, Chicago, IL): +1(773)439-1173" . self::EOL
            . "-(Canada, Toronto, ON): +1(647)558-4860" . self::EOL
            . "-(IT, Rome): +39(06)9480-4403" . self::EOL
            . "From public phone:" . self::EOL
            . "-(USA, Seattle, WA): +1 (206)279-5109" . self::EOL
            . "TOLL FREE (USA): +1(844)637-4229" . self::EOL
            . self::EOL
            . "IMPORTANT! Please note, our rates are based on local access number usage. "
            . "When you use our service by the TOLL FREE access, additional $0.03 USD / min applied to our standard rates. "
            . "PLEASE CHECK YOUR EMAIL ABOUT THE DETAILS!" . self::EOL
            . self::EOL
            . "Thank you for using our services!" . self::EOL
            . "Please do not forget to send a positive feedback if you are satisfied" . self::EOL
            . "with our fast shipping and high quality services." . self::EOL
            . "www.4call.us",
            $this->transaction->getSubscription()->getDefaultPin(),
            $this->transaction->getQuantity(),
            round($this->transaction->getItemValue(), 2)
        );

        return $message;
    }

    /**
     * @return string
     */
    private function getCreditAddedMessage(): string
    {
        $message = sprintf(
            "We added credit to your existing account. " . self::EOL
            . "We sent this information to your PayPal email too." . self::EOL
            . self::EOL
            . self::EOL
            . "Card PIN: %s" . self::EOL
            . "Balance added: %s x $%s USD" . self::EOL
            . self::EOL
            . "Access numbers:" . self::EOL
            . self::EOL
            . "From private phone:" . self::EOL
            . "-(USA, Los Angeles, CA): +1(213)232-0250" . self::EOL
            . "-(USA, NY): +1(914)226-2560" . self::EOL
            . "-(USA, Chicago, IL): +1(773)439-1173" . self::EOL
            . "-(Canada, Toronto, ON): +1(647)558-4860" . self::EOL
            . "-(IT, Rome): +39(06)9480-4403" . self::EOL
            . "From public phone:" . self::EOL
            . "-(USA, Seattle, WA): +1 (206)279-5109" . self::EOL
            . "TOLL FREE (USA): +1(844)637-4229" . self::EOL
            . self::EOL
            . "IMPORTANT! Please note, our rates are based on local access number usage. "
            . "When you use our service by the TOLL FREE access, additional $0.03 USD / min applied to our standard rates. "
            . "PLEASE CHECK YOUR EMAIL ABOUT THE DETAILS!" . self::EOL
            . self::EOL
            . "Thank you for using our services!" . self::EOL
            . "Please do not forget to send a positive feedback if you are satisfied" . self::EOL
            . "with our fast shipping and high quality services." . self::EOL
            . "www.4call.us",
            $this->transaction->getSubscription()->getDefaultPin(),
            $this->transaction->getQuantity(),
            round($this->transaction->getItemValue(), 2)
        );

        return $message;
    }
}
