<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        // Redirect unauthenticated users to login page
        $middleware->redirectGuestsTo('/login');

        $middleware->alias([
            'active' => \App\Http\Middleware\EnsureUserIsActive::class,
            'role' => \App\Http\Middleware\EnsureUserHasRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Illuminate\Http\Exceptions\PostTooLargeException $e, \Illuminate\Http\Request $request) {
            return back()->withErrors(['file' => 'The uploaded file is too large for the server configuration (Max: 2MB). Please contact the administrator to increase the PHP limits.'])->withInput();
        });

        $exceptions->respond(function (\Symfony\Component\HttpFoundation\Response $response, \Throwable $exception, \Illuminate\Http\Request $request) {
            if ($response->getStatusCode() === 403 && ($request->header('X-Inertia') || (! $request->is('api/*') && ! $request->expectsJson()))) {
                return \Inertia\Inertia::render('Errors/403', [
                    'status' => 403,
                    'message' => $exception->getMessage() ?: 'عذراً، ليس لديك الصلاحية الكافية للوصول إلى هذا القسم.',
                ])->toResponse($request)->setStatusCode(403);
            }

            return $response;
        });
    })->create();
