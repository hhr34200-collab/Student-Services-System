<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->render(function (
            HttpExceptionInterface $e,
            $request
        ) {

            if (!$request->expectsJson()) {

                if ($e->getStatusCode() == 403) {

                    return redirect()
                        ->back()
                        ->with(
                            'error',
                            $e->getMessage() ?: 'ليس لديك صلاحية لتنفيذ هذه العملية.'
                        );

                }

                if ($e->getStatusCode() == 404) {

                    return redirect()
                        ->back()
                        ->with(
                            'warning',
                            $e->getMessage() ?: 'العنصر المطلوب غير موجود.'
                        );

                }

            }

        });

    })
    ->create();