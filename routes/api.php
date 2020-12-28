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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('customers')->group(function(){
    Route::get('/','CustomerController@index');
    Route::post('/','CustomerController@store');
    Route::put('/{id}','CustomerController@update');
    Route::get('/{id}','CustomerController@show');
    Route::delete('/{id}','CustomerController@destroy');
});
