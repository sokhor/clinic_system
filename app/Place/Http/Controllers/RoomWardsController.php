<?php

namespace App\Place\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Place\Http\Resources\WardResource;
use App\Place\Models\Ward;

class RoomWardsController extends Controller
{
    /**
     * Get wards.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return WardResource::collection(
            Ward::select('name_en', 'id')->get()
        );
    }
}
