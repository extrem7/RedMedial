<?php

use Illuminate\Support\Facades\Route;
use Illuminate\View\FileViewFinder;

Route::group(['prefix' => 'admin'], function () {
    app()->bind('view.finder', function ($app) {
        $paths = [resource_path('admin/views')];
        return new FileViewFinder($app['files'], $paths);
    });

    Route::get('/', 'Admin\Controller@index');
});
