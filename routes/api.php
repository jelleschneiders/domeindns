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


Route::prefix('api/v1')->middleware('auth:api')->group(function () {

    Route::get('domains', 'API\ZonesController@index');
    Route::post('domains', 'API\ZonesController@store');
    Route::get('domains/{id}', 'API\ZonesController@show');
    Route::delete('domains/{id}', 'API\ZonesController@destroy');
    Route::get('domains/{id}/dnssec', 'API\ZonesController@showDNSSEC');
    Route::get('domains/{id}/records', 'API\RecordController@show');
    Route::post('domains/{id}/records', 'API\RecordController@store');
    Route::delete('domains/{id}/records/{recordid}', 'API\RecordController@destroy');
    Route::get('reseller/users', 'API\ResellerController@index');
    Route::post('reseller/users', 'API\ResellerController@store');
});
