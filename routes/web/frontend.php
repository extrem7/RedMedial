<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Frontend')->as('frontend.')->group(function () {
    Route::get('/', 'PageController@home')->name('home');

    Route::prefix('/blog')->as('articles.')->group(function () {
        Route::get('/', 'ArticleController@index')->name('index');
        Route::get('/{article:slug}', 'ArticleController@show')->name('show');
    });

    Route::get('/search', 'PageController@search')->name('search');

    Route::post('/contact-form', 'PageController@contactForm')->name('contact-form');

    Route::get('/{page:slug}', 'PageController@show')->name('pages.show');
});
