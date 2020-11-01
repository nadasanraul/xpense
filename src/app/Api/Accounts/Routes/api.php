<?php

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

Route::middleware('auth:api')->name('users.')->prefix('users')->group(function () {
    Route::name('single.')->prefix('{userUuid}')->group(function () {

        Route::name('accounts.')->prefix('accounts')->group(function () {
            Route::get('/', 'UserAccountsController@list')->name('list');
            Route::get('{uuid}', 'UserAccountsController@single')->name('single');
        });

    });
});
