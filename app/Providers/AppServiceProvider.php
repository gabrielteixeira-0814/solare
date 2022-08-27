<?php

namespace App\Providers;

use App\Models\User;
use App\Repositories\UserRepositoryEloquent;

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
        // User
        $this->app->bind('App\Repositories\UserRepositoryInterface', 'App\Repositories\UserRepositoryEloquent');

        $this->app->bind('App\Repositories\UserRepositoryInterface', function(){
            return new UserRepositoryEloquent(new User());
        });
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
