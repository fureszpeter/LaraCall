<?php

namespace LaraCall\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;
use LaraCall\Jobs\SendFailedJobNotification;
use Orangehill\Iseed\IseedServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Queue::failing(function (JobFailed $event) {
            dispatch(new SendFailedJobNotification($event));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /*
        * Non-production service providers.
        */
        if ($this->app->environment() !== 'production') {
            if (class_exists(Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class)) {
                $this->app->register(IdeHelperServiceProvider::class);
            }
            $this->app->register(IseedServiceProvider::class);
        }
    }
}
