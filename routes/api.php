<?php

use Illuminate\Http\Request;

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
/*
Route::group(['middleware' => 'cors'], function () {
    Route::post('login', 'ApiController@login');
    Route::post('register', 'ApiController@register');
});
*/
Route::middleware('cors')->group(function(){
    Route::post('login', 'ApiController@login');
    Route::post('register', 'ApiController@register');
 });
Route::group(['middleware' => ['auth.jwt', 'cors']], function () {
    Route::get('logout', 'ApiController@logout');
 
    Route::get('user', 'ApiController@getAuthUser');
    Route::post('update', 'ApiController@update');
 
    Route::get('products', 'ProductController@index');
    Route::get('products/{id}', 'ProductController@show');
    Route::post('products', 'ProductController@store');
    Route::put('products/{id}', 'ProductController@update');
    Route::delete('products/{id}', 'ProductController@destroy');
    Route::post('connectUsers', 'ConnectedUsersController@store');
    Route::get('connectUsers', 'ConnectedUsersController@index');
});

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/