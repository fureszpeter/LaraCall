<?php

namespace LaraCall\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Message;
use Illuminate\Queue\Events\JobFailed;
use Snowfire\Beautymail\Beautymail;

class SendFailedJobNotification
{
    use Dispatchable;

    /**
     * @var JobFailed
     */
    private $event;

    /**
     * @param JobFailed $event
     */
    public function __construct(JobFailed $event)
    {
        $this->event = $event;
    }

    /**
     * Execute the job.
     *
     * @param Beautymail $beautyMail
     */
    public function handle(Beautymail $beautyMail)
    {
        $data = [
            'subject' => 'Job failed!',
            'connection' => $this->event->connectionName,
            'job' => $this->event->job->getName(),
            'exception' => $this->event->exception->getMessage(),
            'trace' => $this->event->exception->getTraceAsString(),
        ];

        $beautyMail->send('emails.job_failed', $data, function (Message $message) {
            $message
                ->from('info@4call.us')
                ->to(env('EMAIL_ADMIN_EMAIL'), env('EMAIL_ADMIN_NAME'))
                ->subject('Job failed!');
        });
    }
}
