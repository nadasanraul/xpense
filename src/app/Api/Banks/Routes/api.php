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
    Route::put('/{uuid}', 'AccountsController@update')->name('update');
    Route::delete('/{uuid}', 'AccountsController@delete')->name('update');

    Route::name('single')->prefix('{uuid}')->group(function () {
        Route::get('/', 'AccountsController@single');
        Route::name('.transactions')->prefix('transactions')->group(function () {
            Route::get('/', 'AccountTransactionsController@list')->name('.list');
            Route::post('/', 'AccountTransactionsController@create')->name('.create');
            Route::get('/{transactionUuid}', 'AccountTransactionsController@single')->name('.single');
            Route::put('/{transactionUuid}', 'AccountTransactionsController@update')->name('.update');
            Route::delete('/{transactionUuid}', 'AccountTransactionsController@delete')->name('.delete');
        });
    });
});

Route::middleware('auth:api')->name('users.')->prefix('users')->group(function () {
    Route::name('single.')->prefix('{userUuid}')->group(function () {
        Route::name('accounts.')->prefix('accounts')->group(function () {
            Route::get('/', 'UserAccountsController@list')->name('list');
            Route::get('{uuid}', 'UserAccountsController@single')->name('single');
        });
    });
});
