<?php

namespace VCComponent\Laravel\TestPostManage\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use VCComponent\Laravel\TestPostManage\Events\PostCreatedEvent;
use VCComponent\Laravel\TestPostManage\Events\PostDeletedEvent;
use VCComponent\Laravel\TestPostManage\Events\PostUpdatedEvent;
use VCComponent\Laravel\TestPostManage\Listeners\EmailPostCreated;
use VCComponent\Laravel\TestPostManage\Listeners\EmailPostDeleted;
use VCComponent\Laravel\TestPostManage\Listeners\EmailPostUpdated;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PostCreatedEvent::class => [
            EmailPostCreated::class,
        ],
        PostUpdatedEvent::class => [
            EmailPostUpdated::class,
        ],
        PostDeletedEvent::class => [
            EmailPostDeleted::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
