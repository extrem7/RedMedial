<?php

/**
 * @routeNamespace("Modules\Frontend\Http\Controllers")
 * @routePrefix("frontend.")
 */

Route::get('/', 'PageController@home')->name('home');

Route::get('/sitemap.xml', 'HelperController@sitemap');

Route::prefix('/blog')->as('articles.')->group(function () {
    Route::get('/', 'ArticleController@index')->name('index');
    Route::get('/page/{page?}', 'ArticleController@index')->name('index.page');

    Route::get('/{article:slug}', 'ArticleController@show')->name('show');
});

Route::as('rss.')->group(function () {
    Route::get('/countries/{country:slug}', 'RssController@country')->name('countries.show');

    Route::prefix('/channels/{channel:slug}')->name('channels.show')->group(function () {
        Route::get('/', 'RssController@channel');
        Route::get('/page/{page?}', 'RssController@channel')->name('.page');
    });

    Route::prefix('categories/{category:slug}')->name('categories.show')->group(function () {
        Route::get('/', 'RssController@category');
        Route::get('/page/{page?}', 'RssController@category')->name('.page');
    });

    Route::get('/posts/{post:slug}', 'RssController@show')->name('posts.show');
});

Route::prefix('/search')->as('search')->group(function () {
    Route::get('/', 'SearchController');
    Route::get('/page/{page?}', 'SearchController')->name('.page');
});

Route::prefix('/iframe')->as('iframe.')->group(function () {
    Route::get('/hot', 'IframeController@hot')->name('hot');
    Route::as('covid.')->group(function () {
        Route::get('/covid-news', 'IframeController@covid')->name('news');
        Route::get('/covid-map', 'IframeController@map')->name('map');
    });

});

Route::post('/contact-form', 'PageController@contactForm')->name('contact-form');

Route::get('/{pageModel:slug}', 'PageController@show')->name('pages.show');
