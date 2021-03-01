<?php

use Modules\Frontend\Http\Controllers\{
    HelperController,
    PageController,
    ArticleController,
    RssController,
    SearchController,
    IframeController
};

Route::get('', [PageController::class, 'home'])->name('home');

Route::get('sitemap.xml', [HelperController::class, 'sitemap']);

Route::prefix('blog')->as('articles.')->group(function () {
    Route::get('', [ArticleController::class, 'index'])->name('index');
    Route::get('page/{page?}', [ArticleController::class, 'index'])->name('index.page');

    Route::get('{article:slug}', [ArticleController::class, 'show'])->name('show');
});

Route::as('rss.')->group(function () {
    Route::get('countries/{country:slug}', [RssController::class, 'country'])->name('countries.show');

    Route::prefix('channels/{channel:slug}')->name('channels.show')->group(function () {
        Route::get('', [RssController::class, 'channel']);
        Route::get('page/{page?}', [RssController::class, 'channel'])->name('.page');
    });

    Route::prefix('categories/{category:slug}')->name('categories.show')->group(function () {
        Route::get('', [RssController::class, 'category']);
        Route::get('page/{page?}', [RssController::class, 'category'])->name('.page');
    });

    Route::get('posts/{post:slug}', [RssController::class, 'show'])->name('posts.show');
});

Route::prefix('search')->as('search')->group(function () {
    Route::get('', SearchController::class);
    Route::get('page/{page?}', SearchController::class)->name('.page');
});

Route::prefix('iframe')->as('iframe.')->group(function () {
    Route::get('hot', [IframeController::class, 'hot'])->name('hot');
    Route::as('covid.')->group(function () {
        Route::get('covid-news', [IframeController::class, 'covid'])->name('news');
        Route::get('covid-map', [IframeController::class, 'map'])->name('map');
    });

});

Route::post('contact-form', [PageController::class, 'contactForm'])->name('contact-form');

Route::get('{pageModel:slug}', [PageController::class, 'show'])->name('pages.show');
