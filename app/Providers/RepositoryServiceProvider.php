<?php

namespace LaraCall\Providers;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\ServiceProvider;
use LaraCall\Domain\Entities\Country;
use LaraCall\Domain\Entities\EbayPaymentTransaction;
use LaraCall\Domain\Entities\EbayPriceList;
use LaraCall\Domain\Entities\EbayUser;
use LaraCall\Domain\Entities\PaymentTransaction;
use LaraCall\Domain\Entities\PayPalIpn;
use LaraCall\Domain\Entities\Pin;
use LaraCall\Domain\Entities\State;
use LaraCall\Domain\Entities\Subscription;
use LaraCall\Domain\Entities\User;
use LaraCall\Domain\Repositories\CountryRepository;
use LaraCall\Domain\Repositories\EbayPaymentTransactionRepository;
use LaraCall\Domain\Repositories\EbayPriceListRepository;
use LaraCall\Domain\Repositories\EbayUserRepository;
use LaraCall\Domain\Repositories\PaymentTransactionRepository;
use LaraCall\Domain\Repositories\PayPalIpnRepository;
use LaraCall\Domain\Repositories\PinRepository;
use LaraCall\Domain\Repositories\StateRepository;
use LaraCall\Domain\Repositories\SubscriptionRepository;
use LaraCall\Domain\Repositories\UserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /** @var EntityManagerInterface $em */
        $em = $this->app->make(EntityManagerInterface::class);

        $this->app->singleton(PayPalIpnRepository::class, function () use ($em) {
            return $em->getRepository(PayPalIpn::class);
        });
        $this->app->singleton(UserRepository::class, function () use ($em) {
            return $em->getRepository(User::class);
        });
        $this->app->singleton(EbayUserRepository::class, function () use ($em) {
            return $em->getRepository(EbayUser::class);
        });
        $this->app->singleton(EbayPriceListRepository::class, function () use ($em) {
            return $em->getRepository(EbayPriceList::class);
        });
        $this->app->singleton(CountryRepository::class, function () use ($em) {
            return $em->getRepository(Country::class);
        });
        $this->app->singleton(StateRepository::class, function () use ($em) {
            return $em->getRepository(State::class);
        });
        $this->app->singleton(SubscriptionRepository::class, function () use ($em) {
            return $em->getRepository(Subscription::class);
        });
        $this->app->singleton(PinRepository::class, function () use ($em) {
            return $em->getRepository(Pin::class);
        });
        $this->app->singleton(PaymentTransactionRepository::class, function () use ($em) {
            return $em->getRepository(PaymentTransaction::class);
        });
        $this->app->singleton(EbayPaymentTransactionRepository::class, function () use ($em) {
            return $em->getRepository(EbayPaymentTransaction::class);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {


    }
}
