<?php
namespace LaraCall\Domain\Factories;

use LaraCall\Domain\ValueObjects\PaymentStatus;
use UnexpectedValueException;

class PaymentStatusFactory
{
    /**
     * @param array $data
     *
     * @return PaymentStatus
     *
     * Canceled_Reversal: A reversal has been canceled. For example, you won a dispute with the customer, and the funds
     * for the transaction that was reversed have been returned to you. Completed: The payment has been completed, and
     * the funds have been added successfully to your account balance. Created: A German ELV payment is made using
     * Express Checkout. Denied: You denied the payment. This happens only if the payment was previously pending
     * because of possible reasons described for the pending_reason variable or the Fraud_Management_Filters_x
     * variable. Expired: This authorization has expired and cannot be captured. Failed: The payment has failed. This
     * happens only if the payment was made from your customer’s bank account. Pending: The payment is pending. See
     * pending_reason for more information. Refunded: You refunded the payment. Reversed: A payment was reversed due to
     * a chargeback or other type of reversal. The funds have been removed from your account balance and returned to
     * the buyer. The reason for the reversal is specified in the ReasonCode element. Processed: A payment has been
     * accepted. Voided: This authorization has been voided.
     */
    public function createFromPayPalIpn(array $data): PaymentStatus
    {
        switch ($data['payment_status']) {
            case 'Completed':
            case 'Created':
            case 'Processed':
                $transactionStatus = new PaymentStatus(PaymentStatus::STATUS_COMPLETED);
                break;
            case 'Canceled_Reversal':
                $transactionStatus = new PaymentStatus(PaymentStatus::STATUS_CANCEL_REVERSED);
                break;
            case 'Failed':
            case 'Expired':
            case 'Denied':
                $transactionStatus = new PaymentStatus(PaymentStatus::STATUS_FAILED);
                break;
            case 'Pending':
                $transactionStatus = new PaymentStatus(PaymentStatus::STATUS_PENDING);
                break;
            case 'Refunded':
                $transactionStatus = new PaymentStatus(PaymentStatus::STATUS_REFUNDED);
                break;
            case 'Reversed':
                $transactionStatus = new PaymentStatus(PaymentStatus::STATUS_REVERSED);
                break;
            default:
                throw new UnexpectedValueException(
                    sprintf('Unknown status received. [status: %s, known: %s]',
                        $data['payment_status'],
                        implode(',', PaymentStatus::VALID_STATUSES)
                    )
                );
                break;
        }

        return $transactionStatus;

    }
}
