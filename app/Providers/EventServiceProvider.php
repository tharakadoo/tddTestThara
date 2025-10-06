<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\PostPublished;
use App\Listeners\SendPostPublishedEmail;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PostPublished::class => [
            SendPostPublishedEmail::class,
        ],
    ];
}
