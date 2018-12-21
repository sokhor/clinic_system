<?php

namespace App\Repositories;

use App\Models\Patient;
use Illuminate\Support\Carbon;

class PatientRepository
{
    /**
     * Create a new patient.
     *
     * @param  Array  $params
     * @return \App\Models\Patient $patient
     */
    public function create(Array $params)
    {
        $patient = Patient::where(function($builder) use ($params) {
                $builder->where('identity_no', $params['identity_no'])
                    ->where('identity_type', $params['identity_type']);
            })
            ->first();

        if($patient) {
            $patient->update(array_merge($params, [
                'dob' => Carbon::createFromFormat(config('app.date_format'), $params['dob'])->format('Y-m-d'),
                'registered_by' => auth()->id(),
            ]));
            return $patient->fresh();
        }

        return Patient::create(
            array_merge($params, [
                'dob' => Carbon::createFromFormat(config('app.date_format'), $params['dob'])->format('Y-m-d'),
                'registered_by' => auth()->id(),
            ])
        );
    }

    /**
     * Update a new patient.
     *
     * @param  int $id
     * @param  Array  $params
     * @return \App\Models\Patient $patient
     */
    public function update($id, Array $params)
    {
        $patient = Patient::findOrFail($id);
        $patient->update(array_merge($params, [ 'registered_by' => auth()->id() ]));

        return $patient->fresh();
    }
}