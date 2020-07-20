<?php

namespace Modules\Frontend\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Modules\Frontend\Http\Middleware\Geoip;
use Modules\Frontend\Http\Middleware\Pagination;

class RouteServiceProvider extends ServiceProvider
{
    protected $moduleNamespace = 'Modules\Frontend\Http\Controllers';

    public function boot()
    {
        Route::pattern('page', '[0-9]+');

        parent::boot();
    }

    public function map()
    {
        $this->mapWebRoutes();
    }

    protected function mapWebRoutes()
    {
        Route::domain(config('redmedial.frontend_domain'))
            ->middleware(['web', Geoip::class, Pagination::class])
            ->namespace($this->moduleNamespace)
            ->as('frontend.')
            ->group(module_path('Frontend', '/Routes/web.php'));
    }
}
