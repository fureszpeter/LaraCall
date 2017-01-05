<?php
namespace LaraCall\Domain\Registration;

use Illuminate\Support\ServiceProvider;
use LaraCall\Domain\Registration\Services\UserService;
use LaraCall\Domain\Registration\Services\UserServiceInterface;

class RegistrationServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }
}
