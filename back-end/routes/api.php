<?php
Route::post('login', 'LoginController@login');
Route::get('logout', 'LoginController@logout')->middleware('auth');

Route::group(['middleware' => 'auth'], function() {
    Route::put('users/{user}/password/reset', 'UserPasswordResetController@update');
    Route::apiResource('users', 'UserController');
});
