<?php

Route::group(['middleware' => 'auth'], function() {
    Route::apiResource('patients', 'PatientController');
    Route::apiResource('queues', 'QueueController');
    Route::apiResource('visits', 'VisitController');
});