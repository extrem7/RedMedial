<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        \Validator::extend('active_rss', function ($attribute, $value, $parameters, $validator) {
            /* @var $feed \SimplePie */
            $feed = \Feeds::make($value, null, true);
            return !$feed->error();
        });
    }
}
