<?php

namespace App\Providers;

use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Eloquent\Document\DocumentRepository;
use App\Repositories\Eloquent\Document\DocumentRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
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
        $this->app->singleton(
            UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->singleton(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );
        $this->app->singleton(
            DocumentRepositoryInterface::class,
            DocumentRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Eloquent\User\UserRepositoryInterface::class,
            \App\Repositories\Eloquent\User\UserRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Eloquent\Category\CategoryRepositoryInterface::class,
            \App\Repositories\Eloquent\Category\CategoryRepository::class
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
