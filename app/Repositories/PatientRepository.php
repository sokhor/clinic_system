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
    public function create(array $params)
    {
        $params = array_merge($params, [
            'dob' => !is_null($params['dob']) && !empty($params['dob']) ? Carbon::createFromFormat(config('app.date_format'), $params['dob'])->format('Y-m-d') : null,
            'last_visited_at' => now()->format('Y-m-d H:i:s'),
        ]);

        if ($patient = $this->existsingPatient($params['identity_no'], $params['identity_type'])) {
            return tap($patient)->update($params);
        }

        return Patient::create($params);
    }

    /**
     * Update a new patient.
     *
     * @param  int $id
     * @param  Array  $params
     * @return \App\Models\Patient
     */
    public function update($id, array $params)
    {
        $patient = Patient::findOrFail($id);
        return tap($patient)->update($params);
    }

    /**
     * Existing patient
     *
     * @param  string $identity_no
     * @param  int $identity_type
     * @return \App\Models\Patient|null
     */
    private function existsingPatient($identity_no, $identity_type)
    {
        return Patient::where('identity_no', $identity_no)
            ->where('identity_type', $identity_type)
            ->first();
    }
}
