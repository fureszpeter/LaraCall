<?php
namespace LaraCall\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Snowfire\Beautymail\Beautymail;

class SendTestEmailJob extends Job implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @param Beautymail $beautyMail
     */
    public function handle(
        Beautymail $beautyMail
    )
    {
        $data = [
            'subject'         => 'Ebay Payment complete!',
            'newSubscription' => 'test-new',
            'name'            => 'test name',
            'ebayId'          => 'ebay id',
            'email'           => 'mock@email.com',
            'pin'             => 'test pin',
            'country'         => 'test country',
            'state'           => 'test state',
            'amount'          => 5,
            'quantity'        => 1,
            'date'            => new \DateTime(),
            /*
             * Subscription details
             */
            'regDate'         => new \DateTime(),
            'pinCount'        => '123',
            'lastPurchases'   => [],
        ];

        $beautyMail->send('emails.payment_complete', $data, function (Message $message) {
            $message
                ->from('info@4call.us')
                ->to(env('EMAIL_ADMIN_EMAIL'), env('EMAIL_ADMIN_NAME'))
                ->subject('Payment complete!');
        });
    }
}
