<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', ['middleware' => ['api']], function (Router $api) {
    $api->group(['namespace' => 'Modules\Api\Http\Controllers'], function (Router $api) {
        $api->get('/', 'HelperController@root');

        $api->get('/countries', 'CountryController@index');
        $api->get('/geoip', 'CountryController@geoip');

        $api->group(['middleware' => ['auth:sanctum']], function (Router $api) {
            $api->get('/playlists', 'PlaylistController');

            $api->group(['prefix' => '/channels'], function (Router $api) {
                $api->get('/', 'ChannelController@index');
                $api->get('/international', 'ChannelController@international');
                $api->post('/suggest', 'ChannelController@suggest');
                $api->group(['prefix' => '/favorite', 'middleware' => ['auth:sanctum']], function (Router $api) {
                    $api->get('/', 'FavoriteController@index');
                    $api->post('/{channel}', 'FavoriteController@toggle');
                });
            });

            $api->group(['prefix' => '/posts'], function (Router $api) {
                $api->get('/', 'PostController@index');
                $api->get('/search', 'PostController@search');
                $api->get('/{post}', 'PostController@show');
            });

            $api->group(['prefix' => '/articles'], function (Router $api) {
                $api->get('/', 'ArticleController@index');
                $api->get('/{article}', 'ArticleController@show');
            });

            $api->group(['prefix' => '/pages'], function (Router $api) {
                $api->get('/red-de-medios', 'PageController@redDeMedios');
            });

            $api->group(['prefix' => '/users'], function (Router $api) {
                $api->get('/self', 'UserController@self');
                $api->patch('/update', 'UserController@update');
            });
        });

        $api->group(['prefix' => '/users', 'middleware' => ['guest']], function (Router $api) {
            $api->post('/register', 'UserController@register');
            $api->post('/login', 'UserController@login');
        });
        $api->post('/users/reset-password', 'UserController@resetPassword');

        $api->group(['prefix' => '/mimedio'], function (Router $api) {
            $api->get('/categories', 'MiMedioController@categories');
            $api->get('/categories/{category}', 'MiMedioController@category');
        });
    });
});
