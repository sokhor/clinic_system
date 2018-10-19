<?php

namespace App\Place\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Place\Http\Requests\WardCreateRequest;
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
}
