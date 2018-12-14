<?php

namespace App\Patient\Repositories;

use App\Patient\Models\Patient;

class PatientRepository
{
    /**
     * Create a new patient.
     *
     * @param  Array  $params
     * @return \App\Patient\Models\Patient $patient
     */
    public function create(Array $params)
    {
        $patient = Patient::where(function($builder) use ($params) {
                $builder->where('identity_no', $params['identity_no'])
                    ->where('identity_type', $params['identity_type']);
            })
            ->first();

        if($patient) {
            $patient->update(array_merge($params, [ 'registered_by' => auth()->id() ]));
            return $patient->fresh();
        }

        return Patient::create(
            array_merge($params, [ 'registered_by' => auth()->id() ])
        );
    }

    /**
     * Update a new patient.
     *
     * @param  int $id
     * @param  Array  $params
     * @return \App\Patient\Models\Patient $patient
     */
    public function update(Patient $patient, Array $params)
    {
        $patient = Patient::findOrFail($id);
        $patient->update(array_merge($params, [ 'registered_by' => auth()->id() ]));

        return $patient->fresh();
    }
}