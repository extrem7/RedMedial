<?php

use Modules\Admin\Http\Middleware\Admin;

Route::middleware('guest')->group(function () {
    Route::get('/login', 'LoginController@showLoginForm')->name('login');
    Route::post('/login', 'LoginController@login')->name('login.try');
});

Route::middleware(Admin::class)->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::prefix('/rss')->namespace('Rss')->as('rss.')->group(function () {
        Route::resource('/channels', 'ChannelController', ['names' => 'channels'])->except(['show']);
        Route::post('/channels/{channel}/toggle-active', 'ChannelController@toggleActive')->name('channels.toggle-active');
        Route::get('/channels/sort', 'ChannelController@sortForm')->name('channels.sort');
        Route::post('/channels/sort', 'ChannelController@sort')->name('channels.sort.update');

        Route::resource('/countries', 'CountryController', ['names' => 'countries'])->except(['show']);
        Route::post('/countries/sort', 'CountryController@sort')->name('countries.sort');

        Route::resource('/categories', 'CategoryController', ['names' => 'categories'])->except(['show']);
    });

    Route::resource('/pages', 'PageController', ['names' => 'pages'])->except(['show']);

    Route::resource('/articles', 'ArticleController')->except('show');

    Route::resource('/playlists', 'PlaylistController')->except('show');
    Route::post('/playlists/sort', 'PlaylistController@sort')->name('playlists.sort');

    Route::resource('/users', 'UserController', ['names' => 'users'])->except(['show']);
    Route::group(['as' => 'users.', 'prefix' => 'users'], function () {
        Route::get('/search', 'UserController@search')->name('search');
    });

    Route::post('/media', 'MediaController@upload')->name('media.upload');

    Route::post('logout', 'LoginController@logout')->name('logout');
});
