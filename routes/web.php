<?php
Route::get('/', function () {
    return redirect()->route('auth.index');
    // return view('auth::index');
});
