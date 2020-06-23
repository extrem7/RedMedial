<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Frontend')->as('frontend.')->group(function () {
    Route::get('/', 'PageController@home')->name('home');
    Route::prefix('/blog')->as('articles.')->group(function () {
        Route::get('/', 'ArticleController@index')->name('index');
        Route::get('/{article:slug}', 'ArticleController@show')->name('show');
    });
});
