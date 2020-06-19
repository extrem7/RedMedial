<?php

use App\Http\Middleware\Admin;

Route::middleware('guest')->group(function () {
    Route::get('/login', 'LoginController@showLoginForm')->name('login');
    Route::post('/login', 'LoginController@login')->name('login.try');
});

Route::middleware(Admin::class)->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::post('logout', 'LoginController@logout')->name('logout');

    Route::resource('/articles', 'ArticleController')->except('show');
    Route::group(['prefix' => '/articles', 'as' => 'articles.'], function () {
        Route::post('sort', 'ArticleController@sort')->name('sort');
    });

    Route::resource('/users', 'UserController', ['names' => 'users'])->except(['show']);
    Route::group(['as' => 'users.', 'prefix' => 'users'], function () {
        Route::get('/search', 'UserController@search')->name('search');
    });
});

//Route::get('/logout', 'PagesController@abort');
