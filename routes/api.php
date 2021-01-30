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

Route::group(['prefix' => 'apps', 'middleware' => 'auth:sanctum'], function($route){

    Route::group(['prefix' => 'control'], function($e){
        Route::get('/{slug}', 'ApplicationController@show');
    });
    /** list only the avaible apps for the user, maybe will be the home page after login */
    Route::get('', 'ApplicationController@index'); 
    Route::get('/{slug}', 'ApplicationController@show');
    Route::post('new', 'ApplicationController@store');
});
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
