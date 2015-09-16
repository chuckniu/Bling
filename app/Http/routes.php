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

Route::get('/', 'FeedController@index');

Route::get('home', 'HomeController@index');

Route::resource('post', 'PostController');

Route::resource('profile', 'ProfileController');

Route::resource('follow', 'FollowController');

Route::resource('feed', 'FeedController');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
