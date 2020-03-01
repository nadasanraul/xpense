<?php

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function() {
    Route::get('login/{driver}', 'LoginController@login')->name('login');
    Route::get('handle/{driver}', 'LoginController@handleRedirect')->name('redirect');
});
