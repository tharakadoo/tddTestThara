<?php

namespace App\Providers;

use App\Infrastructure\Services\EmailService as ServicesEmailService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use WebsitePost\Contracts\EmailServiceContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            EmailServiceContract::class,
            ServicesEmailService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }

}
