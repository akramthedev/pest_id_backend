<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiter as CacheRateLimiter;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter as RateLimiterFacade;
use Illuminate\Routing\Middleware\ThrottleRequests;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Define rate limits
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(200);  
        });

        RateLimiter::for('second', function (Request $request) {
            return Limit::perSecond(10);  
        });
    }
}
