<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/sanctum/token', 'LoginController@login');
Route::post('/user/registration', 'LoginController@create');
Route::get('/user', 'LoginController@user')->middleware('auth:sanctum');

Route::group(['prefix' => 'users', 'middleware' => 'auth:sanctum', 'IsAdmin'], function ($route) {
    Route::get("", 'UsersController@index');
    Route::get("/{id}", 'UsersController@show');
});

Route::group(['prefix' => 'apps', 'middleware' => 'auth:sanctum'], function ($route) {

    //@TODO: see if this route will be used
    Route::group(['prefix' => 'control'], function ($e) {
        Route::get('/{slug}', 'ApplicationController@show');
    });

    //get application collections
    Route::group(['prefix' => '/{slug}/collections'], function ($e) {
        Route::get('', 'ApplicationController@listCollections');
        Route::post('/create', 'CollectionController@create');
        Route::get('/{collection}', 'CollectionController@show');
    });

    //show list of apps
    Route::get('', 'ApplicationController@index');
    //show one app by slug
    Route::get('/{slug}', 'ApplicationController@show');
    //create new app
    Route::post('new', 'ApplicationController@store');
});

Route::group(['prefix' => 'collections', 'middleware' => 'auth:sanctum'], function ($route) {
    //List the collection from application slug
    Route::get('/{app}', 'ApplicationController@show');
});