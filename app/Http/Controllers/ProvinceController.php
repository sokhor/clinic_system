<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Domain\Share\Models\Province;
use App\Http\Resources\ProvinceResource;

class ProvinceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $provinces = Province::all();

        return ProvinceResource::collection($provinces);
    }
}
