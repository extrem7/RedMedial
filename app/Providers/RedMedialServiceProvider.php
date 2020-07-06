<?php

namespace App\Providers;

use App\Models\Rss\Country;
use App\Services\ArticlesService;
use App\Services\SocialService;
use Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Route2Class;
use Str;

class RedMedialServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->sharedData();

        $this->viewComposer();

        $this->schema();

        $this->directives();
    }

    protected function sharedData()
    {
        View::composer(['frontend.layouts.master', 'admin::layouts.master'], function () {
            share([
                'app' => [
                    'name' => config('app.name'),
                    'env' => config('app.env'),
                ],
                'csrf' => csrf_token(),
                'mobileApp' => config('redmedial.mobile-app'),
                'social' => $this->getSocial()
            ]);
        });
        View::composer('frontend.layouts.master', function () {
            share([
                'countries' => $this->getCountries()
            ]);
        });
    }

    protected function viewComposer()
    {
        View::composer(['frontend.layouts.master', 'admin::layouts.master'], function ($view) {
            $bodyClass = Route2Class::generateClassString();
            $bodyClass = (string)Str::of($bodyClass)->replace('login', 'login-page');
            $view->with('bodyClass', $bodyClass);
        });
        View::composer('frontend.errors.404', function ($view) {
            $articlesService = app(ArticlesService::class);
            $view->with('articles', $articlesService->get404());
        });
        View::composer('frontend.includes.archive-sidebar', function ($view) {
            $articlesService = app(ArticlesService::class);
            $view->with('articlesInSidebar', $articlesService->getSidebar());
        });
    }

    protected function schema()
    {
        /* View::composer('layouts.app', function ($view) {
             $schema = collect();

             $schema->push($organization);

             $schema->push($menu);

             $schema = $schema->map(fn(BaseType $item) => $item->toScript());

             $view->with('schema', $schema);
         }); */
    }

    protected function directives()
    {
        Blade::directive('schema', function () {
            return '<?php $schema->each(fn($item)=>print($item)); ?>';
        });
    }

    protected function getCountries()
    {
        return Country::pluck('name', 'slug');
    }

    protected function getSocial()
    {
        $social = config('redmedial.social');

        $socialService = new SocialService();
        $counters = $socialService->get();

        foreach ($social as $type => $item) {
            if (isset($counters[$type]))
                $social[$type]['count'] = $counters[$type];
        }
        return $social;
    }
}
