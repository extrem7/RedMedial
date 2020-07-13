<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Rss\Country;
use App\Observers\ArticleObserver;
use App\Observers\Rss\CountryObserver;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Repositories\Interfaces\CountryRepositoryInterface;
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

        Article::observe(ArticleObserver::class);
        Country::observe(CountryObserver::class);
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
            $articleRepository = app(ArticleRepositoryInterface::class);
            $view->with('articles', $articleRepository->get404());
        });
        View::composer('frontend.includes.archive-sidebar', function ($view) {
            $articleRepository = app(ArticleRepositoryInterface::class);
            $view->with('articlesInSidebar', $articleRepository->getSidebar());
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
        $countryRepository = app(CountryRepositoryInterface::class);
        return $countryRepository->getForHeader();
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
