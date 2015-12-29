<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'web'], function () {
    Route::auth();
});

Route::group(['middleware' => 'auth'], function (){
    Route::get('/', 'DashboardController@index');
    Route::get('/profile', 'ProfileController@index');
    Route::get('/dashboard', 'DashboardController@index');
});

Route::get('/register', function(){ return 'user registration is here'; });
