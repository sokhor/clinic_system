<?php

namespace App\Reception\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Reception\Http\Requests\PatientCreateRequest;
use App\Reception\Models\Patient;
use App\Reception\Repositories\PatientRepository;
use App\Reception\Repositories\QueueRepositroy;

class RegisterController extends Controller
{
    /**
     * Queue repository
     *
     * @var \App\Reception\Repositories\PatientRepository
     */
    protected $patient;

    /**
     * Queue repository
     *
     * @var \App\Reception\Repositories\QueueRepositroy
     */
    protected $queue;

    /**
     * Create the controller instance
     *
     * @param \App\Reception\Repositories\PatientRepository $patient
     * @param \App\Reception\Repositories\QueueRepositroy $queue
     */
    public function __construct(PatientRepository $patient, QueueRepositroy $queue)
    {
        $this->patient = $patient;
        $this->queue = $queue;
    }

    /**
     * Register a new patient.
     *
     * @param  \App\Place\Http\Requests\PatientCreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatientCreateRequest $request)
    {
        $patient = $this->patient->create($request->all());
        $this->queue->generate($patient);

        return $patient;
    }
}
