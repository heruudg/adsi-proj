<?php

namespace App\Providers;

use App\Services\NavigationService;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

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
        Inertia::share([
            'auth.user' => function () {
                return auth()->user() ? [
                    'id' => auth()->user()->id,
                    'name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                    // Add other user fields you need
                ] : null;
            },
            'navigation' => function () {
                if (auth()->check()) {
                    $navigationService = app(NavigationService::class);
                    return [
                        'mainNavItems' => $navigationService->getMainNavItems(),
                    ];
                }
                return null;
            },
        ]);
    }
}
