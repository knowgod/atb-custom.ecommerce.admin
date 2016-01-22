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

Route::group(['middleware' => 'web'], function (){

    Route::get('/', function (){
        return Redirect::to('dashboard');
    });

    Route::auth();

    Route::get('register', function (){
        return Redirect::to('dashboard'); //we are disabling a registration possibility
    });

    Route::get('auth/social/login/google', 'Auth\Social\GoogleController@redirectToProvider');
    Route::get('auth/social/callback/google', 'Auth\Social\GoogleController@handleProviderCallback');

    Route::group(['middleware' => 'auth'], function (){

        Route::group(['namespace' => 'Admin'], function (){
            Route::get('dashboard', 'DashboardController@index');

            Route::get('profile', 'ProfileController@index');
            Route::post('profile/update', 'ProfileController@update');
        });

        Route::group(['namespace' => 'User'], function (){

            Route::get('user/list', 'UserController@index');
            Route::get('user/create', 'UserController@showCreateForm');
            Route::post('user/create', 'UserController@create');
            Route::get('user/view/{id}', 'UserController@view');

            Route::get('user/update/id/{id}', 'UserController@showUpdateForm');
            Route::post('user/update', 'UserController@update');

            Route::get('user/delete/id/{id}', 'UserController@delete');
            Route::post('user/mass/delete', 'UserController@massDelete');

        });

        Route::group(['namespace' => 'Order'], function (){

            Route::get('order/list', 'OrderController@index');
            Route::get('order/create', 'OrderController@showCreateForm');
            Route::get('order/grid', 'OrderController@showGrid');
            Route::post('order/create', 'OrderController@create');
            Route::get('order/view/id/{id}', 'OrderController@view');

            Route::get('order/update/id/{id}', 'OrderController@showUpdateForm');
            Route::post('order/update', 'OrderController@update');

            Route::get('order/delete/id/{id}', 'OrderController@delete');
            Route::post('order/mass/delete', 'OrderController@massDelete');
        });

        Route::group(['namespace' => 'Invite'], function () {
            Route::get('invite/create', ['as' => 'invite/create', 'uses' => 'InviteController@create']);
            Route::post('invite/store', ['as' => 'invite/store', 'uses' => 'InviteController@store']);
            Route::get('invite/list',  'InviteController@index');
            Route::get('invite/resend/id/{id}', 'InviteController@resend');

        });

        Route::group(['namespace' => 'Acl'], function () {
            Route::get('permission/list', 'PermissionController@listAll');
            Route::get('role/list', 'RoleController@index');

            Route::get('role/create', 'RoleController@create');
        });
    });
});
