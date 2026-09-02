<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use App\Http\View\Composers\FarmComposer;
use Illuminate\Support\Facades\Gate;

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

        /***************************************************
    
            Gate Definitions for restricting access
        
        ****************************************************/
        Gate::define('inventory-access', function ($user) {
            return $user->hasAnyRole(['Operations', 'Operational Manager', 'Owner']);
        });

        Gate::define('sales-access', function ($user) {
            return $user->hasAnyRole(['Sales', 'Sales Manager', 'Owner']);
        });

        Gate::define('admin-access', function ($user) {
            return $user->hasAnyRole(['Operational Manager', 'Sales Manager', 'Owner']);
        });

        Gate::define('admin-ops-access', function ($user) {
            return $user->hasAnyRole(['Operational Manager', 'Owner']);
        });

        Gate::define('admin-sales-access', function ($user) {
            return $user->hasAnyRole(['Sales Manager', 'Owner']);
        });

    }
}
