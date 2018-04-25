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

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['namespace' => 'Api'], function () use ($router) {

        $router->get('actors', ['uses' => 'ActorController@index']);
        $router->post('actors', ['uses' => 'ActorController@store']);
        $router->get('actors/{actorId}', ['uses' => 'ActorController@show']);
        $router->put('actors/{actorId}', ['uses' => 'ActorController@update']);
        $router->delete('actors/{actorId}', ['uses' => 'ActorController@destroy']);

        $router->get('categories', ['uses' => 'CategoryController@index']);
        $router->post('categories', ['uses' => 'CategoryController@store']);
        $router->get('categories/{categoryId}', ['uses' => 'CategoryController@show']);
        $router->put('categories/{categoryId}', ['uses' => 'CategoryController@update']);
        $router->delete('categories/{categoryId}', ['uses' => 'CategoryController@destroy']);

    });
});
