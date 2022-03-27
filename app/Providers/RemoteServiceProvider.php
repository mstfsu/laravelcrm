<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Overrides\RemoteManager;
class RemoteServiceProvider   extends \Collective\Remote\RemoteServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('remote', function ($app) {
            return new RemoteManager($app);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
