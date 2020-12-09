<?php

namespace Modules\Frontend\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Modules\Frontend\Http\Middleware\Geoip;
use Modules\Frontend\Http\Middleware\Pagination;

class RouteServiceProvider extends ServiceProvider
{
    protected string $moduleNamespace = 'Modules\Frontend\Http\Controllers';

    public function boot(): void
    {
        Route::pattern('page', '[0-9]+');

        parent::boot();
    }

    public function map(): void
    {
        $this->mapWebRoutes();
    }

    protected function mapWebRoutes(): void
    {
        $routes = fn() => Route::middleware(['web', Geoip::class, Pagination::class])
            ->namespace($this->moduleNamespace)
            ->as('frontend.')
            ->group(module_path('Frontend', '/Routes/web.php'));

        /*if (config('app.env') === 'production')
            Route::group(['domain' => 'www.' . config('redmedial.frontend_domain')], $routes);*/
        Route::group(['domain' => config('redmedial.frontend_domain')], $routes);
        Route::group(['domain' => 'www.' . config('redmedial.frontend_domain')], $routes);
    }
}
