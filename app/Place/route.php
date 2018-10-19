<?php

Route::group(['middleware' => 'auth'], function() {
    Route::apiResource('wards', 'WardController');
});