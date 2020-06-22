<?php

namespace App\Providers;

use Auth;
use Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Route2Class;
use SEOMeta;
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

    private function sharedData()
    {
        share([
            'app' => [
                'name' => config('app.name'),
                'env' => config('app.env'),
            ],
        ]);
    }

    private function viewComposer()
    {
        View::composer(['layouts.app'], function ($view) {
            $bodyClass = Route2Class::generateClassString();
            $bodyClass = (string)Str::of($bodyClass)->replace('login', 'login-page');
            $view->with('bodyClass', $bodyClass);
        });
        View::composer(['layouts.base'], function ($view) {
            Route2Class::addClass('sidebar-mini');
            $title = str_replace(SEOMeta::getTitleSeparator() . SEOMeta::getDefaultTitle(), '', SEOMeta::getTitle());
            if ($title) {
                $view->with('pageTitle', $title);
            }
        });
        View::composer('includes.sidebar', function ($view) {
            $view->with('name', ucfirst(Auth::user()->name));
        });
    }

    private function schema()
    {
        /* View::composer('layouts.app', function ($view) {
             $schema = collect();

             $schema->push($organization);

             $schema->push($menu);

             $schema = $schema->map(fn(BaseType $item) => $item->toScript());

             $view->with('schema', $schema);
         }); */
    }

    private function directives()
    {
        Blade::directive('schema', function () {
            return '<?php $schema->each(fn($item)=>print($item)); ?>';
        });
    }
}
