<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', ['middleware' => ['api']], function (Router $api) {
    $api->group(['namespace' => 'Modules\Api\Http\Controllers'], function (Router $api) {
        $api->get('/countries', 'CountryController@index');
        $api->get('/geoip', 'CountryController@geoip');

        $api->get('/playlists', 'PlaylistController');

        $api->group(['prefix' => '/channels'], function (Router $api) {
            $api->get('/', 'ChannelController@index');
            $api->get('/international', 'ChannelController@international');
            $api->post('/suggest', 'ChannelController@suggest');
        });

        $api->group(['prefix' => '/posts'], function (Router $api) {
            $api->get('/', 'PostController@index');
            $api->get('/{post}', 'PostController@show');
        });

        $api->group(['prefix' => '/articles'], function (Router $api) {
            $api->get('/', 'ArticleController@index');
            $api->get('/{article}', 'ArticleController@show');
        });
    });
});
