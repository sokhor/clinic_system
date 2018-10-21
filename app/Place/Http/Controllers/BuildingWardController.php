<?php

namespace App\Place\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Place\Http\Requests\BuildingAttachWardRequest;
use App\Place\Http\Resources\WardResource;
use App\Place\Models\Building;
use App\Place\Models\Ward;

class BuildingWardController extends Controller
{
    /**
     * Get wards.
     *
     * @param  \App\Http\Requests\BuildingAttachWardRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(BuildingAttachWardRequest $request)
    {
        return WardResource::collection(Ward::all());
    }

    /**
     * Attach wards.
     *
     * @param  \App\Http\Requests\BuildingAttachWardRequest $request
     * @return \Illuminate\Http\Response
     */
    public function attach(BuildingAttachWardRequest $request, $id)
    {
        $building = Building::findOrFail($id);

        $building->wards()->sync($request->all());

        return WardResource::collection($building->fresh()->wards);
    }
}
