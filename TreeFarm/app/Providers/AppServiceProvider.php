<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use App\Http\View\Composers\FarmComposer;

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
        // Enforces the correct URL starting point for the application
        URL::forceScheme('https');
        URL::forceRootUrl(config('app.url'));

        // Provides information to every page, even the signup and registration pages
        View::composer('*', FarmComposer::class);
    }
}
