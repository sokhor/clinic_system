<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Domain\Share\Models\Commune;
use App\Http\Resources\CommuneResource;

class CommuneController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $communes = Commune::all();

        return CommuneResource::collection($communes);
    }
}
