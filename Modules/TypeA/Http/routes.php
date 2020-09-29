<?php

Route::group(['middleware' => 'web', 'prefix' => 'typea', 'namespace' => 'Modules\TypeA\Http\Controllers'], function()
{
    Route::get('/get_log_user', 'TypeAController@get_log_user');
    Route::get('/get_att_log', 'TypeAController@get_att_log');
    Route::get('/reg_mesin', 'TypeAController@reg_mesin');
    Route::get('/add_user_to_mesin', 'TypeAController@add_user_to_mesin');
    Route::get('/delete_user', 'TypeAController@delete_user');
    Route::get('/restart', 'TypeAController@restart');
    Route::get('/poweroff', 'TypeAController@poweroff');
    Route::get('/get_date', 'TypeAController@get_date');
});
