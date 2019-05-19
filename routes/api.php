<?php
Route::post('login', 'LoginController@login');
Route::post('logout', 'LoginController@logout')->middleware('auth');
Route::get('authenticated', 'LoginController@authenticated')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
    Route::put('users/{user}/password/reset', 'UserPasswordResetController@update');
    Route::post('users/{user}/roles', 'UserAttachRoleController');
    Route::delete('users/{user}/roles', 'UserDetachRoleController');
    Route::apiResource('users', 'UserController');
    Route::apiResource('roles', 'RoleController');
    Route::get('abilities', 'AbilitiesController@index');
    Route::apiResource('patients', 'PatientController');
    Route::apiResource('visits', 'VisitController');
    Route::get('appointments/doctors', 'AppointmentController@doctors');
    Route::get('appointments/patients', 'AppointmentController@patients');
    Route::apiResource('appointments', 'AppointmentController');

    //Administration
    Route::post('companies/logos', 'Administration\CompanyLogoUploadController');
    Route::get('companies/{id}/logo', 'Administration\CompanyLogoController@show');
    Route::apiResource('companies', 'Administration\CompanyController');

    //Human resource
    Route::apiResource('employees', 'HumanResource\EmployeeController');

    // Queue
    Route::apiResource('queue-sections', 'Queue\QueueSectionController');
    Route::apiResource('queue-counters', 'Queue\QueueCounterController');
    Route::put('queues/{queue}/counter', 'Queue\QueueSetCounterController@update');
    Route::post('queues', 'Queue\QueueController@store');
    Route::get('queues', 'Queue\QueueController@index');

    // Inventory
    Route::apiResource('products', 'Inventory\ProductController');
});
