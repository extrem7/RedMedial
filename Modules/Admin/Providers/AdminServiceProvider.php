<?php

namespace Modules\Admin\Providers;

use Artesaos\SEOTools\Facades\SEOMeta;
use Auth;
use Cookie;
use Illuminate\Support\ServiceProvider;
use Route2Class;
use View;

class AdminServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Admin';

    protected string $moduleNameLower = 'admin';

    public function boot(): void
    {
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

        View::composer(['admin::layouts.base'], function ($view) {
            Route2Class::addClass('sidebar-mini');

            $title = str_replace(SEOMeta::getTitleSeparator() . SEOMeta::getDefaultTitle(), '', SEOMeta::getTitle());
            if ($title) {
                $view->with('pageTitle', $title);
            }

            if (Cookie::get('sidebar-toggle-collapsed')) {
                Route2Class::addClass('sidebar-collapse');
            }
        });
        View::composer('admin::includes.sidebar', function ($view) {
            $view->with('name', ucfirst(Auth::getUser()->name));
        });
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }

    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom($sourcePath, $this->moduleNameLower);
    }
}
