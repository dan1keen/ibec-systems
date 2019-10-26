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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('corrals/create', 'SheepController@createCorrals');
Route::get('sheeps', 'SheepController@index');
Route::get('corrals', 'SheepController@indexForCorrals');
Route::post('sheeps/create', 'SheepController@createSheeps');
Route::get('reports', 'ReportController@index');
Route::get('report/{key}', 'ReportController@show');
