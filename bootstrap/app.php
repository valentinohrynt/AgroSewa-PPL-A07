<?php

use App\Http\Middleware\OnlyAdmin;
use App\Http\Middleware\OnlyLender;
use App\Http\Middleware\OnlyBorrower;
use Illuminate\Foundation\Application;
use App\Http\Middleware\OnlyGovernment;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(OnlyAdmin::class);
        $middleware->append(OnlyBorrower::class);
        $middleware->append(OnlyGovernment::class);
        $middleware->append(OnlyLender::class);

        $middleware->alias([
            'only_admin' => OnlyAdmin::class,
            'only_borrower' => OnlyBorrower::class,
            'only_government' => OnlyGovernment::class,
            'only_lender' => OnlyLender::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
