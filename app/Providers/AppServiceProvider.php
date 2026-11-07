<?php

namespace App\Providers;

use App\Models\PaymentAccount;
use App\Policies\PaymentAccountPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Never render detailed exception pages in production, even if an
        // environment file was accidentally deployed with APP_DEBUG=true.
        if ($this->app->isProduction()) {
            config(['app.debug' => false]);
        }

        // Named rate limiters are not registered here because the API throttle
        // is enforced inside AuthenticateApiKey (RateLimiter::tooManyAttempts /
        // RateLimiter::hit with explicit keys).  Route-level throttle:X,Y
        // middleware handles public endpoint limits via Laravel's built-in
        // ThrottleRequests middleware.

        Gate::policy(PaymentAccount::class, PaymentAccountPolicy::class);

        view()->share('csp_nonce', '');

        // Use relative root paths for Vite assets so they load flawlessly over HTTPS/HTTP on any host without mixed-content issues
        \Illuminate\Support\Facades\Vite::createAssetPathsUsing(fn ($path) => '/' . ltrim($path, '/'));

        // Force HTTPS for all external/public hosts
        if (isset($_SERVER['HTTP_HOST']) && ! str_contains($_SERVER['HTTP_HOST'], 'localhost') && ! str_contains($_SERVER['HTTP_HOST'], '127.0.0.1')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
