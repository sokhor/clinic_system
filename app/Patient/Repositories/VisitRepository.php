<?php

namespace App\Patient\Repositories;

use App\Patient\Models\Patient;
use App\Patient\Models\Visit;

class VisitRepository
{
    /**
     * Generate a new queue
     *
     * @param  \App\Patient\Models\Patient $patient
     * @return \App\Patient\Models\Visit
     */
    public function generateGueue(Patient $patient, int $progress)
    {
        $visit = Visit::whereDate('created_at', today())->latest()->first();

        return Visit::create([
            'patient_id' => $patient->id,
            'queue_no' => $visit ? $visit->queue_no + 1 : 1,
            'status' => 0,
            'progress' => $progress,
        ]);
    }
}