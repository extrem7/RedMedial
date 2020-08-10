<?php

namespace Modules\Api\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Api';

    protected string $moduleNameLower = 'api';

    public function boot(): void
    {
        JsonResource::withoutWrapping();
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
