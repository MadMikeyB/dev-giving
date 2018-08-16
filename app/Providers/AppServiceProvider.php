<?php

namespace Sprocketbox\DevGiving\Providers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\Factory;
use Sprocketbox\DevGiving\Entities\Users\Users;
use Sprocketbox\DevGiving\Http\Controllers\GithubController;
use Sprocketbox\DevGiving\Respite\GitHub\GithubProvider;
use Sprocketbox\DevGiving\Respite\JustGiving\JustGivingProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Setup injection so we don't have to mess around with facades
        $this->app->when(GithubController::class)
                  ->needs(\Laravel\Socialite\Two\GithubProvider::class)
                  ->give(function () {
                      return $this->app->make(Factory::class)->driver('github');
                  });

        $this->app->when(Users::class)
                  ->needs(Guard::class)
                  ->give(function () {
                      return $this->app['auth']->guard('web');
                  });

        // Register respite providers
        respite()->extend('github', GithubProvider::class);
        respite()->extend('justgiving', JustGivingProvider::class);
    }
}
