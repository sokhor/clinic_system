<?php

namespace App\Repositories;

use App\Models\Visit;
use App\Models\Queue;

class VisitRepository
{
    /**
     * Create a new visit
     *
     * @param  Array $params
     * @return \App\Models\Visit
     */
    public function create($params)
    {
        $visit = Visit::create(array_merge($params, [
            'progress' => isset($params['progress']) ? $params['progress'] : 1,
            'referal_id' => isset($params['referal_id']) ? $params['referal_id'] : null,
            'registered_by' => auth()->id()
        ]));

        $this->generateGueue($visit, [
            'assigned_id' => $params['assigned_id'],
        ]);

        return $visit;
    }

    /**
     * Generate a new queue
     *
     * @param  \App\Models\Visit $patient
     * @param  Array $data
     * @return \App\Models\Queue
     */
    public function generateGueue($visit, $params)
    {
        $queue = Queue::whereDate('created_at', today())->latest()->first();

        return Queue::create([
            'patient_id' => $visit->patient_id,
            'visit_id' => $visit->id,
            'queue_no' => $queue ? $queue->queue_no + 1 : 1,
            'assigned_id' => isset($params['assigned_id']) ? $params['assigned_id'] : null,
            'status' => 0,
        ]);
    }
}