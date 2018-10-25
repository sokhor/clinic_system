<?php

Route::group(['middleware' => 'auth'], function() {
    Route::apiResource('reception/register', 'RegisterController');
});