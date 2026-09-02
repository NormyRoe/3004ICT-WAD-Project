<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        
        // Registering Middleware
        $middleware->alias([

            // Inventory Access Middleware
            'can.inventory' => \App\Http\Middleware\InventoryAccess::class,
            // Sales Access Middleware
            'can.sales' => \App\Http\Middleware\SalesAccess::class,
            // Admin Access Middleware
            'can.admin' => \App\Http\Middleware\AdminAccess::class,
            // Admin Ops Access Middleware
            'can.admin-ops' => \App\Http\Middleware\AdminOpsAccess::class,
            // Admin Sales Access Middleware
            'can.admin-sales' => \App\Http\Middleware\AdminSalesAccess::class,

        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
