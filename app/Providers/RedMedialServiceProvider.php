<?php

namespace App\Providers;

use App\Services\CacheService;
use Blade;
use Illuminate\Support\ServiceProvider;

class RedMedialServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('cacher', function () {
            return new CacheService();
        });
    }

    public function boot()
    {
        $this->schema();

        $this->directives();
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
}
