<?php

namespace App\Providers;

use App\Services\ArticlesService;
use App\Services\SocialService;
use Artesaos\SEOTools\Facades\SEOMeta;
use Auth;
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

        $this->adminViewComposer();
        $this->viewComposer();

        $this->schema();

        $this->directives();
    }

    protected function sharedData()
    {
        share([
            'app' => [
                'name' => config('app.name'),
                'env' => config('app.env'),
            ],
            'mobileApp' => config('redmedial.mobile-app'),
            'social' => $this->getSocial()
        ]);
    }

    protected function adminViewComposer()
    {
        View::composer(['admin.layouts.base'], function ($view) {
            Route2Class::addClass('sidebar-mini');
            $title = str_replace(SEOMeta::getTitleSeparator() . SEOMeta::getDefaultTitle(), '', SEOMeta::getTitle());
            if ($title) {
                $view->with('pageTitle', $title);
            }
        });
        View::composer('admin.includes.sidebar', function ($view) {
            $view->with('name', ucfirst(Auth::user()->name));
        });
    }

    protected function viewComposer()
    {
        View::composer(['frontend.layouts.master', 'admin.layouts.app'], function ($view) {
            $bodyClass = Route2Class::generateClassString();
            $bodyClass = (string)Str::of($bodyClass)->replace('login', 'login-page');
            $view->with('bodyClass', $bodyClass);
        });
        View::composer('frontend.errors.404', function ($view) {
            $articlesService = app(ArticlesService::class);
            $view->with('articles', $articlesService->get404());
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
