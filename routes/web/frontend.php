<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Frontend')->as('frontend.')->group(function () {
    Route::get('/', 'PageController@home')->name('home');

    Route::prefix('/blog')->as('articles.')->group(function () {
        Route::get('/', 'ArticleController@index')->name('index');
        Route::get('/{article:slug}', 'ArticleController@show')->name('show');
    });

    Route::as('rss.')->group(function () {
        Route::get('/countries/{country:slug}', 'RssController@country')->name('countries.show');
        Route::get('/channels/{channel:slug}', 'RssController@channel')->name('channels.show');
        Route::get('/rss/{post:slug}', 'RssController@show')->name('posts.show');
    });

    Route::get('/search', 'PageController@search')->name('search');

    Route::post('/contact-form', 'PageController@contactForm')->name('contact-form');

    Route::get('/{page:slug}', 'PageController@show')->name('pages.show');
});
