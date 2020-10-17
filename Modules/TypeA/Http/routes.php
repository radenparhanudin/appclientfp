<?php

Route::group(['middleware' => ['web','CekLogin'], 'prefix' => 'typea', 'namespace' => 'Modules\TypeA\Http\Controllers'], function()
{
    Route::get('dashboard', 'DashboardController@index')->name('typea.dashboard.index');
    Route::get('check-mesin-support', 'TypeAController@index')->name('typea.check-mesin-support.index');
	Route::post('check-mesin-support/check', 'TypeAController@check')->name('typea.check-mesin-support.check');

	Route::get('register-mesin/data', 'RegisterMesinController@data')->name('typea.register-mesin.data');
	Route::get('register-mesin', 'RegisterMesinController@index')->name('typea.register-mesin.index');
	Route::post('register-mesin', 'RegisterMesinController@store')->name('typea.register-mesin.store');
	Route::get('register-mesin/{id}/edit', 'RegisterMesinController@edit')->name('typea.register-mesin.edit');
	Route::put('register-mesin/{id}', 'RegisterMesinController@update')->name('typea.register-mesin.update');

    
    Route::get('upload-log-user', 'UploadLogUserController@index')->name('typea.upload-log-user.index');
    Route::post('upload-log-user', 'UploadLogUserController@store')->name('typea.upload-log-user.store');
    Route::get('upload-log-user/data', 'UploadLogUserController@data')->name('typea.upload-log-user.data');
    Route::post('upload-log-user/get_mesin', 'UploadLogUserController@get_mesin')->name('typea.upload-log-user.get_mesin');

    Route::get('upload-log-attandance', 'UploadLogAttandanceController@index')->name('typea.upload-log-attandance.index');
    Route::post('upload-log-attandance/get_mesin', 'UploadLogAttandanceController@get_mesin')->name('typea.upload-log-attandance.get_mesin');
    Route::post('upload-log-attandance', 'UploadLogAttandanceController@store')->name('typea.upload-log-attandance.store');
    Route::get('upload-log-attandance/data', 'UploadLogAttandanceController@data')->name('typea.upload-log-attandance.data');
    Route::post('upload-log-attandance/get_tanggal_terakhir', 'UploadLogAttandanceController@get_tanggal_terakhir')->name('typea.upload-log-attandance.get_tanggal_terakhir');
});
