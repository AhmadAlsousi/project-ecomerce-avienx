<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
    use Illuminate\Support\Facades\Schema;
    // use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;


class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        URL::forceScheme('https');
        Schema::defaultStringLength(191);

        if ($appUrl = config('app.url')) {
            URL::forceRootUrl($appUrl);
        }
    }
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
    
}
