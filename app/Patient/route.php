<?php

Route::group(['middleware' => 'auth'], function() {
    Route::apiResource('patients', 'PatientController');
});