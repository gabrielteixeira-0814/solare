<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Project;
use App\Models\Setting;
use App\Repositories\UserRepositoryEloquent;
use App\Repositories\ProjectRepositoryEloquent;
use App\Repositories\SettingRepositoryEloquent;
use Illuminate\Pagination\Paginator;

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

        // Setting
        $this->app->bind('App\Repositories\SettingRepositoryInterface', 'App\Repositories\SettingRepositoryEloquent');

        $this->app->bind('App\Repositories\SettingRepositoryInterface', function(){
            return new SettingRepositoryEloquent(new Setting());
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }
}
