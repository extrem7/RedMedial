<?php

namespace Modules\Api\Providers;

use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Api';

    protected string $moduleNameLower = 'api';

    public function boot(): void
    {

    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
