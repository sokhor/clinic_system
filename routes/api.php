<?php
Route::post('login', 'LoginController@login');
Route::get('logout', 'LoginController@logout')->middleware('auth');

Route::group(['middleware' => 'auth'], function() {
    Route::put('users/{user}/password/reset', 'UserPasswordResetController@update');
    Route::post('users/{user}/roles', 'UserController@attachRoles');
    Route::apiResource('users', 'UserController');
    Route::apiResource('roles', 'RoleController');
    Route::get('abilities', 'AbilitiesController@index');
});
