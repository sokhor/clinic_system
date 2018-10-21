<?php

namespace App\Place\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Place\Http\Requests\BuildingViewRequest;
use App\Place\Http\Resources\BuildingResource;
use App\Place\Models\Building;

class BuildingController extends Controller
{
    /**
     * Get buildings.
     *
     * @param  \App\Http\Requests\BuildingViewRequest $request     *
     * @return \Illuminate\Http\Response
     */
    public function index(BuildingViewRequest $request)
    {
        return BuildingResource::collection(Building::paginate($request->per_page));
    }

    /**
     * Show a building.
     *
     * @param  \App\Http\Requests\BuildingViewRequest $request     *
     * @return \Illuminate\Http\Response
     */
    public function show(BuildingViewRequest $request, Building $Building)
    {
        return new BuildingResource($Building);
    }

    // /**
    //  * Create a building.
    //  *
    //  * @param  \App\Http\Requests\BuildingCreateRequest $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(BuildingCreateRequest $request)
    // {
    //     return new BuildingResource(Building::create($request->all()));
    // }

    // /**
    //  * Update a building.
    //  *
    //  * @param  \App\Http\Requests\BuildingUpdateRequest $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(BuildingUpdateRequest $request, Building $Building)
    // {
    //     $Building->update($request->all());

    //     return new BuildingResource($Building->fresh());
    // }

    // /**
    //  * Delete a building.
    //  *
    //  * @param  \App\Http\Requests\BuildingDeleteRequest $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(BuildingDeleteRequest $request, Building $Building)
    // {
    //     $Building->delete();

    //     return new BuildingResource($Building);
    // }
}
