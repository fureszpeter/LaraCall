<?php
namespace LaraCall\Domain\Factories;

use Carbon\Carbon;
use LaraCall\Domain\Entities\Subscription;
use LaraCall\Domain\Entities\User;

class SubscriptionFactory
{
    const DATE_FORMAT = 'Y-m-d H:i:s';

    /**
     * @param User  $user
     * @param mixed $row
     *
     * @return Subscription
     */
    public static function createFromRow(User $user, $row)
    {
        $subscription = new Subscription($user, $row->username);
        return $subscription->setExpirationDate(
            Carbon::createFromFormat(self::DATE_FORMAT, $row->expirationdate)
        )
            ->setSubscriptionCreationDate(self::DATE_FORMAT, $row->creationdate);
    }
}
