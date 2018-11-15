<?php

namespace App\Patient\Repositories;

use App\Patient\Models\Patient;

class PatientRepository
{
    /**
     * Patient model
     *
     * @var \App\Patient\Models\Patient
     */
    protected $patient;

    /**
     * Create a new patient repository instance.
     *
     * @param \App\Patient\Models\Patient $patient
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

    public function update(Patient $patient, Array $params)
    {
        $patient->update(
            array_merge($params, [ 'registered_by' => auth()->id() ])
        );

        return $patient->fresh();
    }
}