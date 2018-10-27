<?php

namespace App\Reception\Repositories;

use App\Reception\Models\Patient;
use App\Reception\Models\Queue;

class QueueRepositroy
{
    /**
     * Queue model
     *
     * @var \App\Reception\Models\Queue
     */
    protected $queue;

    /**
     * Create a new queue repository instance.
     *
     * @param \App\Reception\Models\Queue $queue
     */
    public function __construct(Queue $queue)
    {
        $this->queue = $queue;
    }

    /**
     * Generate a new queue
     *
     * @param  \App\Reception\Models\Patient $patient
     * @return \App\Reception\Models\Queue
     */
    public function generate(Patient $patient)
    {
        $queue = Queue::latest()->first();

        return Queue::create([
            'patient_id' => $patient->id,
            'queue_no' => $queue ? $queue->id + 1 : 1,
        ]);
    }
}