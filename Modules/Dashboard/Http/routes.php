<?php

Route::group(['middleware' => ['web','CekLogin'], 'prefix' => 'dashboard', 'namespace' => 'Modules\Dashboard\Http\Controllers'], function()
{
    Route::get('/', 'DashboardController@index')->name('dashboard.index');
});
