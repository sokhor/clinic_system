<?php

namespace App\Reception\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Reception\Models\Patient;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Register a new patient.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $patient = Patient::create($request->all());
        $appointment = $patient->appointments()->create($request->all());
        $appointment->queue()->create($request->all());

        return $patient;
    }
}
