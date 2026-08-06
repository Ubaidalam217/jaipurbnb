<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        // Laravel's default paginator markup is Tailwind. This site is
        // Bootstrap 5 end to end, and the template's .pagination-area
        // styles hang off Bootstrap's .pagination / .page-link classes.
        Paginator::useBootstrapFive();

        // Belt and braces alongside trustProxies() in bootstrap/app.php: even
        // if a proxy header goes missing, every generated URL stays https in
        // production, so assets are never emitted as blockable mixed content.
        // Left off locally, where artisan serve is plain http.
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
