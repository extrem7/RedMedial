<?php

namespace Modules\Frontend\Providers;

use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Repositories\Interfaces\ChannelRepositoryInterface;
use App\Repositories\Interfaces\CountryRepositoryInterface;
use App\Services\SocialService;
use Illuminate\Support\ServiceProvider;
use Route2Class;
use View;

class FrontendServiceProvider extends ServiceProvider
{
    protected $moduleName = 'Frontend';

    protected $moduleNameLower = 'frontend';

    public function boot()
    {
        $this->registerConfig();
        $this->registerViews();

        $this->sharedData();
        $this->viewComposer();
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom([$sourcePath], $this->moduleNameLower);
    }

    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'config.php'), $this->moduleNameLower
        );
    }

    protected function sharedData()
    {
        View::composer('frontend::layouts.master', function () {
            share([
                'app' => [
                    'name' => config('app.name'),
                    'env' => config('app.env'),
                ],
                'csrf' => csrf_token(),
                'mobileApp' => config('frontend.mobile-app'),
                'social' => $this->getSocial(),
                'countries' => $this->getCountries()
            ]);
        });
    }

    protected function viewComposer()
    {
        View::composer('frontend::layouts.master', function ($view) {
            $bodyClass = Route2Class::generateClassString();
            $view->with('bodyClass', $bodyClass);
        });
        View::composer('frontend::errors.404', function ($view) {
            $articleRepository = app(ArticleRepositoryInterface::class);
            $view->with('articles', $articleRepository->get404());
        });
        View::composer('frontend::includes.archive-sidebar', function ($view) {
            $articleRepository = app(ArticleRepositoryInterface::class);
            $view->with('articlesInSidebar', $articleRepository->getSidebar());
        });
        View::composer('frontend::includes.single-sidebar', function ($view) {
            $channelRepository = app(ChannelRepositoryInterface::class);
            share([
                'sidebarChannel' => $channelRepository->getSidebar()
            ]);
        });
        View::composer(['frontend::pages.quienes-somos', 'frontend::pages.red-de-medios'], function ($view) {
            $channelRepository = app(ChannelRepositoryInterface::class);
            share([
                'sidebarChannels' => $channelRepository->getSidebar(2)
            ]);
        });
    }

    protected function getCountries()
    {
        $countryRepository = app(CountryRepositoryInterface::class);
        return $countryRepository->getForHeader();
    }

    protected function getSocial()
    {
        $social = config('frontend.social');

        $socialService = new SocialService();
        $counters = $socialService->get();

        foreach ($social as $type => $item) {
            if (isset($counters[$type]))
                $social[$type]['count'] = $counters[$type];
        }
        return $social;
    }
}
