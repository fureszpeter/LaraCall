<?php

namespace LaraCall\Domain\Factories;

use InvalidArgumentException;
use LaraCall\Domain\ValueObjects\PaymentStatus;
use UnexpectedValueException;

class PaymentStatusFactory
{
    /**
     * @param array $data
     *
     * @return PaymentStatus
     *
     * @throws UnexpectedValueException If $data not contains information.
     * @throws InvalidArgumentException If payment_status is not a string.
     *
     * Canceled_Reversal: A reversal has been canceled. For example, you won a dispute with the customer, and the funds
     * for the transaction that was reversed have been returned to you. Completed: The payment has been completed, and
     * the funds have been added successfully to your account balance. Created: A German ELV payment is made using
     * Express Checkout. Denied: You denied the payment. This happens only if the payment was previously pending
     * because of possible reasons described for the pending_reason variable or the Fraud_Management_Filters_x
     * variable. Expired: This authorization has expired and cannot be captured. Failed: The payment has failed. This
     * happens only if the payment was made from your customer’s bank account. Pending: The payment is pending. See
     * pending_reason for more information. Refunded: You refunded the payment. Reversed: A payment was reversed due to
     * a charge-back or other type of reversal. The funds have been removed from your account balance and returned to
     * the buyer. The reason for the reversal is specified in the ReasonCode element. Processed: A payment has been
     * accepted. Voided: This authorization has been voided.
     */
    public function createFromArray(array $data): PaymentStatus
    {
        if (false === array_key_exists('payment_status', $data)) {
            throw new UnexpectedValueException(
                sprintf(
                    'Payment data not contains payment_status information! [data received: %s]',
                    json_encode($data, JSON_PRETTY_PRINT)
                )
            );
        }

        if (false === is_string($data['payment_status'])) {
            throw new InvalidArgumentException(
                sprintf(
                    'payment_status should be a string. [Received: %s]',
                    gettype($data['payment_status'])
                )
            );
        }

        return $this->createFromString($data['payment_status']);
    }

    /**
     * @param string $paymentStatus
     *
     * @return PaymentStatus
     *
     * @throws UnexpectedValueException If invalid status received.
     */
    public function createFromString(string $paymentStatus): PaymentStatus
    {
        $paymentStatus = strtolower($paymentStatus);

        switch ($paymentStatus) {
            case 'completed':
            case 'created':
            case 'processed':
                $transactionStatus = new PaymentStatus(PaymentStatus::STATUS_COMPLETED);
                break;
            case 'canceled_reversal':
                $transactionStatus = new PaymentStatus(PaymentStatus::STATUS_CANCEL_REVERSED);
                break;
            case 'failed':
            case 'expired':
            case 'denied':
                $transactionStatus = new PaymentStatus(PaymentStatus::STATUS_FAILED);
                break;
            case 'pending':
                $transactionStatus = new PaymentStatus(PaymentStatus::STATUS_PENDING);
                break;
            case 'refunded':
                $transactionStatus = new PaymentStatus(PaymentStatus::STATUS_REFUNDED);
                break;
            case 'reversed':
                $transactionStatus = new PaymentStatus(PaymentStatus::STATUS_REVERSED);
                break;
            default:
                throw new UnexpectedValueException(
                    sprintf('Unknown status received. [status: %s, known: %s]',
                        $paymentStatus,
                        implode(',', PaymentStatus::VALID_STATUSES)
                    )
                );
                break;
        }

        return $transactionStatus;
    }
}
