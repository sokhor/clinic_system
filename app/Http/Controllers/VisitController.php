<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\VisitResource;
use App\Models\Visit;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class VisitController extends Controller
{
    /**
     * Get patients visits
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $patients = QueryBuilder::for(Visit::with('patient'))
            ->latest()
            ->paginate($request->per_page);

        return VisitResource::collection($patients);
    }

    /**
     * Show a patient
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $patient = Visit::with('patient')->findOrFail($id);

        return new VisitResource($patient);
    }
}
