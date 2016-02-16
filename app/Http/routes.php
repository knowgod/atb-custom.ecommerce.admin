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

    Route::get('auth/social/login/google',
            ['as' => 'login/google', 'uses' => 'Auth\Social\GoogleController@redirectToProvider']
    );
    Route::get('auth/social/callback/google',
            ['as' => 'login/callback/google', 'uses' => 'Auth\Social\GoogleController@handleProviderCallback']
    );

    Route::group(['middleware' => 'auth'], function (){
        Route::group(['namespace' => 'Admin'], function (){
            Route::get('dashboard', 'DashboardController@index');
            Route::get('profile', 'ProfileController@index');
            Route::post('profile/update', 'ProfileController@update');
        });

        Route::group(['namespace' => 'User'], function (){
            Route::get('user/list', 'UserController@index');
            Route::get('user/create', 'UserController@create');
            Route::post('user/create', 'UserController@store');
            Route::get('user/view/{id}', 'UserController@view');
            Route::get('user/update/id/{id}', 'UserController@edit');
            Route::post('user/update', 'UserController@update');
            Route::get('user/delete/id/{id}', 'UserController@delete');
            Route::post('user/bulk/delete', 'UserController@bulkDelete');
        });

        Route::group(['namespace' => 'Order'], function (){
            Route::get('order/list', 'OrderController@index');
            Route::get('order/create', 'OrderController@create');
            Route::get('order/grid', 'OrderController@showGrid');
            Route::post('order/create', 'OrderController@store');
            Route::get('order/view/id/{id}', 'OrderController@view');
            Route::get('order/update/id/{id}', 'OrderController@edit');
            Route::post('order/update', 'OrderController@update');
            Route::get('order/delete/id/{id}', 'OrderController@delete');
            Route::post('order/bulk/delete', 'OrderController@bulkDelete');
        });

        Route::group(['namespace' => 'Invitation'], function (){
            Route::get('invitation/create', 'InvitationController@create');
            Route::post('invitation/store', 'InvitationController@store');
            Route::get('invitation/list', 'InvitationController@index');
            Route::get('invitation/resend/id/{id}', 'InvitationController@resend');
        });

        Route::group(['namespace' => 'Acl'], function (){
            Route::get('permission/list', 'PermissionController@listAll');
            Route::get('role/list', 'RoleController@index');
            Route::get('role/create', 'RoleController@create');
            Route::post('role/create', 'RoleController@store');
            Route::get('role/view/{id}', 'RoleController@view');
            Route::get('role/update/id/{id}', 'RoleController@edit');
            Route::post('role/update', 'RoleController@update');
            Route::get('role/delete/id/{id}', 'RoleController@delete');
            Route::post('role/bulk/delete', 'RoleController@bulkDelete');
        });
    });
});
