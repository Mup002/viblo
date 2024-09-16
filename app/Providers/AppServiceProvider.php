<?php

namespace App\Providers;

use App\Console\Commands\ScheduleArticle;
use App\Services\NotificationService;
use Illuminate\Support\ServiceProvider;
use PHPUnit\Metadata\Api\Dependencies;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(ScheduleArticle::class,function($app){
            return new ScheduleArticle($app->make(NotificationService::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
