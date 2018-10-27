<?php

namespace App\Reception\Repositories;

use App\Reception\Models\Patient;

class PatientRepository
{
    /**
     * Patient model
     *
     * @var \App\Reception\Models\Patient
     */
    protected $patient;

    /**
     * Create a new patient repository instance.
     *
     * @param \App\Reception\Models\Patient $patient
     */
    public function __construct(Patient $patient)
    {
        $this->patient = $patient;
    }

    public function create(Array $params)
    {
        return Patient::create(
            array_merge($params, [ 'registered_by' => auth()->id() ])
        );
    }
}