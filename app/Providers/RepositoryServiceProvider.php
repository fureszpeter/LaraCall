<?php

namespace LaraCall\Providers;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\ServiceProvider;
use LaraCall\Domain\Entities\Country;
use LaraCall\Domain\Entities\EbayListing;
use LaraCall\Domain\Entities\State;
use LaraCall\Domain\Entities\User;
use LaraCall\Domain\Repositories\CountryRepository;
use LaraCall\Domain\Repositories\EbayListingRepository;
use LaraCall\Domain\Repositories\StateRepository;
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
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CountryRepository::class, function (){
            $em = $this->app->make(EntityManagerInterface::class);
            return $em->getRepository(Country::class);
        });
        $this->app->singleton(StateRepository::class, function (){
            $em = $this->app->make(EntityManagerInterface::class);
            return $em->getRepository(State::class);
        });
        $this->app->singleton(UserRepository::class, function (){
            $em = $this->app->make(EntityManagerInterface::class);

            return $em->getRepository(User::class);
        });
        $this->app->singleton(EbayListingRepository::class, function (){
            $em = $this->app->make(EntityManagerInterface::class);

            return $em->getRepository(EbayListing::class);
        });
    }
}
