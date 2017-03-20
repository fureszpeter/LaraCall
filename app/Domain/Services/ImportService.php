<?php
namespace LaraCall\Domain\Services;

use A2bApiClient\Api\Instances\SubscriptionInstance;
use LaraCall\Domain\Collections\PinCollection;
use LaraCall\Domain\Entities\Pin;
use LaraCall\Domain\Entities\Subscription;
use LaraCall\Domain\Entities\User;

interface ImportService
{
    /**
     * @param SubscriptionInstance[] ...$subscriptionInstances
     */
    public function importSubscriptionInstances(SubscriptionInstance ...$subscriptionInstances);

    /**
     * @param SubscriptionInstance $subscriptionInstance
     *
     * @return Pin
     */
    public function importSubscriptionInstance(SubscriptionInstance $subscriptionInstance): Pin;

    /**
     * @param SubscriptionInstance $subscriptionInstance
     *
     * @return User
     */
    public function importUser(SubscriptionInstance $subscriptionInstance): User;

    /**
     * @param SubscriptionInstance $subscriptionInstance
     * @param User                 $user
     *
     * @return Subscription
     */
    public function importSubscription(SubscriptionInstance $subscriptionInstance, User $user): Subscription;

    /**
     * @param SubscriptionInstance $subscriptionInstance
     * @param Subscription         $subscription
     *
     * @return Pin
     */
    public function importPin(SubscriptionInstance $subscriptionInstance, Subscription $subscription): Pin;

    /**
     * @param string $email
     *
     * @return PinCollection
     */
    public function importByEmail(string $email): PinCollection;
}
