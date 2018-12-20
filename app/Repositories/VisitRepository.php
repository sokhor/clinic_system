<?php

namespace App\Repositories;

use App\Models\Patient;
use App\Models\Visit;

class VisitRepository
{
    /**
     * Generate a new queue
     *
     * @param  \App\Models\Patient $patient
     * @return \App\Models\Visit
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