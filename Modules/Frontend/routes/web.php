<?php

use Modules\Frontend\Http\Controllers\{Account\AuthController,
    Account\MediaController,
    Account\ProfileController,
    PageController,
    ArticleController,
    RssController,
    SearchController,
    IframeController
};
use Modules\Frontend\Http\Middleware\HandleInertiaRequests;

Route::middleware(HandleInertiaRequests::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::prefix('login')->as('login')->group(function () {
            Route::get('', [AuthController::class, 'login']);
            Route::post('', [AuthController::class, 'tryLogin'])->name('.try');
        });
        Route::prefix('register')->as('register')->group(function () {
            Route::get('', [AuthController::class, 'register']);
            Route::post('', [AuthController::class, 'tryRegister'])->name('.try');
        });
        Route::prefix('password-reset')->as('password_reset')->group(function () {
            Route::get('', [AuthController::class, 'resetPassword']);
            Route::post('', [AuthController::class, 'tryResetPassword'])->name('.try');
        });
    });
    Route::middleware('auth')->group(function () {
        Route::delete('logout', [AuthController::class, 'logout'])->name('logout');

        Route::prefix('account')->as('account.')->group(function () {
            Route::prefix('settings')->as('settings.')->group(function () {
                Route::get('', [ProfileController::class, 'edit'])->name('edit');
                Route::post('', [ProfileController::class, 'update'])->name('update');
            });

            Route::prefix('media')->as('media.')->group(function () {
                Route::get('', [MediaController::class, 'edit'])->name('edit');
                Route::post('', [MediaController::class, 'update'])->name('update');

                Route::post('logo', [MediaController::class, 'updateLogo'])->name('logo.update');
                Route::delete('logo', [MediaController::class, 'destroyLogo'])->name('logo.destroy');
                Route::delete('statistic', [MediaController::class, 'destroyStatistic'])->name('statistic');

                Route::post('assistance', [MediaController::class, 'assistance'])->name('assistance');
            });
        });
    });
});

Route::get('', [PageController::class, 'home'])->name('home');

Route::get('sitemap.xml', [AuthController::class, 'sitemap']);

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
