<?php
Route::post('login', 'LoginController@login');
Route::post('logout', 'LoginController@logout')->middleware('auth');
Route::get('authenticated', 'LoginController@authenticated')->middleware('auth');

Route::group(['middleware' => 'auth'], function() {
    Route::put('users/{user}/password/reset', 'UserPasswordResetController@update');
    Route::post('users/{user}/roles', 'UserController@attachRoles');
    Route::put('users/{user}/roles', 'UserController@detachRoles');
    Route::apiResource('users', 'UserController');
    Route::apiResource('roles', 'RoleController');
    Route::get('abilities', 'AbilitiesController@index');
    Route::apiResource('patients', 'PatientController');
    Route::apiResource('visits', 'VisitController');
    Route::get('appointments/doctors', 'AppointmentController@doctors');
    Route::get('appointments/patients', 'AppointmentController@patients');
    Route::apiResource('appointments', 'AppointmentController');

    // Queue
    Route::apiResource('queue-section', 'Queue\QueueSectionController');
    Route::put('queues/{queue}/counter', 'Queue\QueueCounterController@update');
    Route::apiResource('queues', 'Queue\QueueController');

    // Inventory
    Route::apiResource('products', 'Inventory\ProductController');
});
