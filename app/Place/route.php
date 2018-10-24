<?php

Route::group(['middleware' => 'auth'], function() {
    Route::apiResource('wards', 'WardController');
    Route::get('buildings/wards', 'BuildingWardController@index');
    Route::put('buildings/{id}/wards', 'BuildingWardController@attach');
    Route::apiResource('buildings', 'BuildingController');
    Route::get('rooms/wards', 'RoomWardsController@index');
    Route::get('rooms/buildings', 'RoomBuildingsController@index');
    Route::apiResource('rooms', 'RoomController');
});