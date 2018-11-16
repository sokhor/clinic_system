<?php

namespace App\Patient\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Patient\Http\Resources\PatientVisitResource;
use App\Patient\Models\Patient;
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
        $patients = QueryBuilder::for(Patient::withCount('visits'))
            ->allowedFilters(
                'consult_operate_by',
                'status',
                'type'
            )
            ->latest()
            ->paginate($request->per_page);

        return PatientVisitResource::collection($patients);
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
        $patient = Patient::with('visits')->findOrFail($id);

        return new PatientVisitResource($patient);
    }
}
