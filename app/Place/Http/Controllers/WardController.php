<?php

namespace App\Place\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Place\Http\Resources\WardResource;

class WardController extends Controller
{
    /**
     * Get wards.
     *
     * @param  \App\Http\Requests\RoleViewRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return WardResource::collection(Ward::paginate());
    }
}
