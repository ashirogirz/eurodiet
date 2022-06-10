<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('register', 'AuthController@register');

    $router->post('login', 'AuthController@login');

    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->group(['prefix' => 'address'], function () use ($router) {
            $router->get('/', 'AddressController@list');
            $router->get('detail/{id}', 'AddressController@detail');
            $router->post('create', 'AddressController@create');
            $router->put('update/{id}', 'AddressController@update');
            $router->delete('delete/{id}', 'AddressController@delete');
        });
        $router->get('profile', 'AuthController@profile');
    });
    $router->get('repository', 'AuthController@repository');
});
