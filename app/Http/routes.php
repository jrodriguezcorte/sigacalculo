<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'Auth\AuthController@getLogin');

Route::get('home', 'HomeController@index');

Route::get('home/autocomplete', 'HomeController@autocomplete');

Route::post('home/search', 'HomeController@search');

Route::post('home/update', 'HomeController@update');

Route::post('home/result', 'HomeController@result');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

