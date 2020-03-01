<?php

use Illuminate\Support\Facades\Route;

Route::post('token', 'OAuthController@issueToken')
    ->middleware('inject-credentials')
    ->name('get.token');
