<?php

Route::group(['middleware' => 'web', 'prefix' => 'auth', 'namespace' => 'Modules\Auth\Http\Controllers'], function()
{
    Route::get('/', 'AuthController@index')->name('auth.index');
    Route::post('/login', 'AuthController@login')->name('auth.login');
    Route::get('/logout', 'AuthController@logout')->name('auth.logout');
});
