<?php

Route::group(['middleware' => 'auth'], function() {
    Route::apiResource('patient', 'PatientController');
});