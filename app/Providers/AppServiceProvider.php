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

        // Dynamically adjust root URL to match incoming request so CSS/JS assets never get blocked by CSP
        if (env('RENDER_EXTERNAL_URL')) {
            \Illuminate\Support\Facades\URL::forceRootUrl(env('RENDER_EXTERNAL_URL'));
            \Illuminate\Support\Facades\URL::forceScheme('https');
        } elseif (isset($_SERVER['HTTP_HOST'])) {
            $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
                || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https')
                || (isset($_SERVER['HTTP_X_FORWARDED_SSL']) && strtolower($_SERVER['HTTP_X_FORWARDED_SSL']) === 'on')
                || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
            $proto = $isHttps ? 'https' : 'http';
            \Illuminate\Support\Facades\URL::forceRootUrl($proto . '://' . $_SERVER['HTTP_HOST']);
            if ($isHttps) {
                \Illuminate\Support\Facades\URL::forceScheme('https');
            }
        }
    }
}
