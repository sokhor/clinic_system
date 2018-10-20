<?php

namespace App\Place\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Place\Http\Requests\WardCreateRequest;
use App\Place\Http\Requests\WardDeleteRequest;
use App\Place\Http\Requests\WardUpdateRequest;
use App\Place\Http\Requests\WardViewRequest;
use App\Place\Http\Resources\WardResource;
use App\Place\Models\Ward;

class WardController extends Controller
{
    /**
     * Get wards.
     *
     * @param  \App\Http\Requests\RoleViewRequest $request     *
     * @return \Illuminate\Http\Response
     */
    public function index(WardViewRequest $request)
    {
        return WardResource::collection(Ward::paginate());

    /**
     * Show a ward.
     *
     * @param  \App\Http\Requests\RoleViewRequest $request     *
     * @return \Illuminate\Http\Response
     */
    public function show(WardViewRequest $request, Ward $ward)
    {
        return new WardResource($ward);
    }

    /**
     * Create a ward.
     *
     * @param  \App\Http\Requests\WardCreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(WardCreateRequest $request)
    {
        return new WardResource(Ward::create($request->all()));
    }

    /**
     * Update a ward.
     *
     * @param  \App\Http\Requests\WardUpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(WardUpdateRequest $request, Ward $ward)
    {
        $ward->update($request->all());

        return new WardResource($ward->fresh());
    }

    /**
     * Delete a ward.
     *
     * @param  \App\Http\Requests\WardDeleteRequest $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(WardDeleteRequest $request, Ward $ward)
    {
        $ward->delete();

        return new WardResource($ward);
    }
}
