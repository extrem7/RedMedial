<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    Route::get('/', function () {
    })->name('home');
});
