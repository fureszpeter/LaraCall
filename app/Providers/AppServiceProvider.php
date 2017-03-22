<?php

namespace LaraCall\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\ServiceProvider;
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
        //
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
            if (class_exists(Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class)){
                $this->app->register(IdeHelperServiceProvider::class);
            }
            $this->app->register(IseedServiceProvider::class);
        }
    }
}
