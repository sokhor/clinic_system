<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Domain\Share\Models\Village;
use App\Http\Resources\VillageResource;

class VillageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $villages = Village::all();

        return VillageResource::collection($villages);
    }
}
