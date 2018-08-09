<?php

Route::group(['middleware' => 'auth:api'], function() {
    Route::apiResource('users', 'UserController');
});
