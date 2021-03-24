<?php

use Dingo\Api\Routing\Router;
use Modules\Api\Http\Controllers\{
    HelperController,
    CountryController,
    PlaylistController,
    ChannelController,
    FavoriteController,
    PostController,
    ArticleController,
    PageController,
    UserController,
    MiMedioController
};

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', ['middleware' => ['api']], function (Router $api) {

    $api->get('', [HelperController::class, 'root']);

    $api->get('countries', [CountryController::class, 'index']);
    $api->get('geoip', [CountryController::class, 'geoip']);

    $api->group(['middleware' => ['auth:sanctum']], function (Router $api) {
        $api->get('playlists', PlaylistController::class);

        $api->group(['prefix' => 'channels'], function (Router $api) {
            $api->get('', [ChannelController::class, 'index']);
            $api->get('international', [ChannelController::class, 'international']);
            $api->post('suggest', [ChannelController::class, 'suggest']);
            $api->group(['prefix' => 'favorite', 'middleware' => ['auth:sanctum']], function (Router $api) {
                $api->get('', [FavoriteController::class, 'index']);
                $api->post('{channel}', [FavoriteController::class, 'toggle']);
            });
        });

        $api->group(['prefix' => 'posts'], function (Router $api) {
            $api->get('', [PostController::class, 'index']);
            $api->get('search', [PostController::class, 'search']);
            $api->get('{post}', [PostController::class, 'show']);
        });

        $api->group(['prefix' => 'articles'], function (Router $api) {
            $api->get('', [ArticleController::class, 'index']);
            $api->get('{article}', [ArticleController::class, 'show']);
        });

        $api->group(['prefix' => 'pages'], function (Router $api) {
            $api->get('red-de-medios', [PageController::class, 'redDeMedios']);
        });

        $api->group(['prefix' => 'users'], function (Router $api) {
            $api->get('self', [UserController::class, 'self']);
            $api->patch('update', [UserController::class, 'update']);
        });
    });

    $api->group(['prefix' => 'users', 'middleware' => ['guest']], function (Router $api) {
        $api->post('register', [UserController::class, 'register']);
        $api->post('login', [UserController::class, 'login']);
    });
    $api->post('users/reset-password', [UserController::class, 'resetPassword']);

    $api->group(['prefix' => 'mimedio'], function (Router $api) {
        $api->get('categories', [MiMedioController::class, 'categories']);
        $api->get('categories/{category}', [MiMedioController::class, 'category']);
        $api->get('channels', [MiMedioController::class, 'channels']);
        $api->get('post/{post:slug}', [MiMedioController::class, 'post']);
    });
});
