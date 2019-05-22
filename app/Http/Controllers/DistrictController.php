<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Domain\Share\Models\District;
use App\Http\Resources\DistrictResource;

class DistrictController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $districts = District::all();

        return DistrictResource::collection($districts);
    }
}
