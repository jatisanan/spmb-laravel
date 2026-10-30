<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Auto-detect scheme dari request
        // Kalau request via HTTPS (Cloudflare, proxy) → force https
        // Kalau request lokal (http://localhost) → biarkan http
        if (request()->server('HTTP_X_FORWARDED_PROTO') === 'https'
            || request()->isSecure()
            || str_starts_with(config('app.url'), 'https')) {
            URL::forceScheme('https');
        }

        // Fallback: kalau APP_URL kosong, isi otomatis dari request
        if (empty(config('app.url'))) {
            config(['app.url' => request()->getSchemeAndHttpHost()]);
        }
    }
}