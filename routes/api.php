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
| RouteServiceProvider
|
*/

Route::prefix('user')->name('user.')->group(function () {
    Route::get('/', 'UserController@getUser')->name('data');
    Route::get('/domains', 'UserController@getDomains')->name('domains');
    Route::get('/api-token-update', 'Auth\UpdateApiTokenController@update')->name('api-token-update');
});

Route::prefix('dyndns')->name('dyndns.')->group(function () {
    Route::get('/activation', 'DynDnsController@getActivationUrl')->name('activation');
    Route::get('/setup', 'DynDnsController@setup')->name('setup');
    Route::get('/status', 'DynDnsController@status')->name('status');
    Route::get('/update', 'DynDnsController@update')->name('update');
});
