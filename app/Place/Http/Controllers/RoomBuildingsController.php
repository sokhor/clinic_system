<?php

namespace App\Place\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Place\Http\Resources\BuildingResource;
use App\Place\Models\Building;

class RoomBuildingsController extends Controller
{
    /**
     * Get wards.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BuildingResource::collection(
            Building::select('name_en', 'id')->get()
        );
    }
}
