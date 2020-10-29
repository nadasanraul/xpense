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

Route::middleware('auth:api')->name('banks.')->prefix('banks')->group(function () {
    Route::get('/', 'BanksController@list')->name('list');
    Route::post('/', 'BanksController@create')->name('create');
    Route::get('/{uuid}', 'BanksController@single')->name('single');
    Route::put('/{uuid}', 'BanksController@update')->name('update');
    Route::delete('/{uuid}', 'BanksController@delete')->name('update');
});

Route::middleware('auth:api')->name('accounts.')->prefix('accounts')->group(function () {
    Route::get('/', 'AccountsController@list')->name('list');
    Route::post('/', 'AccountsController@create')->name('create');
    Route::get('/{uuid}', 'AccountsController@single')->name('single');
    Route::put('/{uuid}', 'AccountsController@update')->name('update');
    Route::delete('/{uuid}', 'AccountsController@delete')->name('update');
});
