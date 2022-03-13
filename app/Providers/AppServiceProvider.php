<?php

namespace App\Providers;

use App\Api\Regres\Client as RegresClient;
use App\Contracts\Regres\Client;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            Client::class,
            static fn (Application $app): Client => new RegresClient($app['config']->get('regres.base_url'))
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
