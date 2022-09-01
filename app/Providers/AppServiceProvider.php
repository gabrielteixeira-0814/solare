<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Project;
use App\Repositories\UserRepositoryEloquent;
use App\Repositories\ProjectRepositoryEloquent;

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

        // Project
        $this->app->bind('App\Repositories\ProjectRepositoryInterface', 'App\Repositories\ProjectRepositoryEloquent');

        $this->app->bind('App\Repositories\ProjectRepositoryInterface', function(){
            return new ProjectRepositoryEloquent(new Project());
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
