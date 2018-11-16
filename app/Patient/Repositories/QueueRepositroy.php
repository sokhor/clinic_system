<?php

namespace App\Patient\Repositories;

use App\Patient\Models\Patient;
use App\Patient\Models\Queue;

class QueueRepositroy
{
    /**
     * Queue model
     *
     * @var \App\Patient\Models\Queue
     */
    protected $queue;

    /**
     * Create a new queue repository instance.
     *
     * @param \App\Patient\Models\Queue $queue
     */
    public function __construct(Queue $queue)
    {
        $this->queue = $queue;
    }

    /**
     * Generate a new queue
     *
     * @param  \App\Patient\Models\Patient $patient
     * @return \App\Patient\Models\Queue
     */
    public function generate(Patient $patient, $option = [])
    {
        $queue = Queue::whereDate('created_at', today())->latest()->first();

        return Queue::create([
            'patient_id' => $patient->id,
            'queue_no' => $queue ? $queue->queue_no + 1 : 1,
            'status' => isset($option['status']) ? $option['status'] : null,
        ]);
    }
}