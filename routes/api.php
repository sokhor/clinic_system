<?php

Route::group(['middleware' => 'auth:api'], function() {
    Route::put('users/{user}/password/reset', 'UserPasswordResetController@update');
    Route::apiResource('users', 'UserController');
});
