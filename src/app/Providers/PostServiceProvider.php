<?php

namespace VCComponent\Laravel\TestPostManage\Providers;

use Illuminate\Support\ServiceProvider;
use VCComponent\Laravel\TestPostManage\Repositories\PostInterface;
use VCComponent\Laravel\TestPostManage\Repositories\PostRepository;
use VCComponent\Laravel\TestPostManage\Providers\EventServiceProvider;

class PostServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PostInterface::class, PostRepository::class);
        $this->app->register(EventServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }
}
