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

/** @var $router \Laravel\Lumen\Routing\Router */
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

        $router->get('countries', ['uses' => 'CountryController@index']);
        $router->post('countries', ['uses' => 'CountryController@store']);
        $router->get('countries/{countryId}', ['uses' => 'CountryController@show']);
        $router->put('countries/{countryId}', ['uses' => 'CountryController@update']);
        $router->delete('countries/{countryId}', ['uses' => 'CountryController@destroy']);

        $router->get('languages', ['uses' => 'LanguageController@index']);
        $router->post('languages', ['uses' => 'LanguageController@store']);
        $router->get('languages/{languageId}', ['uses' => 'LanguageController@show']);
        $router->put('languages/{languageId}', ['uses' => 'LanguageController@update']);
        $router->delete('languages/{languageId}', ['uses' => 'LanguageController@destroy']);

        $router->get('cities', ['uses' => 'CityController@index']);
        $router->post('cities', ['uses' => 'CityController@store']);
        $router->get('cities/{cityId}', ['uses' => 'CityController@show']);
        $router->put('cities/{cityId}', ['uses' => 'CityController@update']);
        $router->delete('cities/{cityId}', ['uses' => 'CityController@destroy']);

        $router->get('addresses', ['uses' => 'AddressController@index']);
        $router->post('addresses', ['uses' => 'AddressController@store']);
        $router->get('addresses/{addressId}', ['uses' => 'AddressController@show']);
        $router->put('addresses/{addressId}', ['uses' => 'AddressController@update']);
        $router->delete('addresses/{addressId}', ['uses' => 'AddressController@destroy']);

        $router->get('stores', ['uses' => 'StoreController@index']);
        $router->post('stores', ['uses' => 'StoreController@store']);
        $router->get('stores/{storeId}', ['uses' => 'StoreController@show']);
        $router->put('stores/{storeId}', ['uses' => 'StoreController@update']);
        $router->delete('stores/{storeId}', ['uses' => 'StoreController@destroy']);

        $router->get('staff', ['uses' => 'StaffController@index']);
        $router->post('staff', ['uses' => 'StaffController@store']);
        $router->get('staff/{staffId}', ['uses' => 'StaffController@show']);
        $router->put('staff/{staffId}', ['uses' => 'StaffController@update']);
        $router->delete('staff/{staffId}', ['uses' => 'StaffController@destroy']);

        $router->get('customers', ['uses' => 'CustomerController@index']);
        $router->post('customers', ['uses' => 'CustomerController@store']);
        $router->get('customers/{customerId}', ['uses' => 'CustomerController@show']);
        $router->put('customers/{customerId}', ['uses' => 'CustomerController@update']);
        $router->delete('customers/{customerId}', ['uses' => 'CustomerController@destroy']);

        $router->get('films', ['uses' => 'FilmController@index']);
        $router->post('films', ['uses' => 'FilmController@store']);
        $router->get('films/{filmId}', ['uses' => 'FilmController@show']);
        $router->put('films/{filmId}', ['uses' => 'FilmController@update']);
        $router->delete('films/{filmId}', ['uses' => 'FilmController@destroy']);
    });
});
