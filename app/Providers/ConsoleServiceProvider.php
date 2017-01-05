<?php

namespace LaraCall\Providers;

use Illuminate\Support\ServiceProvider;
use PDO;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PDO::class, function(){
            return new PDO(
                sprintf(
                    'mysql:host=%s;dbname=%s;charset=utf8',
                    env('PDO_HOST'),
                    env('PDO_DBNAME')
                ),
                env('PDO_USER'),
                env('PDO_PASS')
            );
        });
    }
}
