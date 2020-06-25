<?php

namespace Modules\Admin\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected string $moduleNamespace = 'Modules\Admin\Http\Controllers';

    public function boot(): void
    {
        parent::boot();
    }

    public function map(): void
    {
        $this->mapWebRoutes();
    }

    protected function mapWebRoutes(): void
    {
        Route::domain(config('redmedial.admin_domain'))
            ->middleware('web')
            ->namespace($this->moduleNamespace)
            ->as('admin.')
            ->group(module_path('Admin', '/Routes/web.php'));
    }
}
