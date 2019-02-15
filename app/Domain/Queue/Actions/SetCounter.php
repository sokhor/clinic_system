<?php

namespace Domain\Queue\Actions;

use Domain\Queue\Models\Queue;
use Domain\Queue\Models\QueueCounter;

class SetCounter
{
    public function __construct(Queue $queue)
    {
        $this->queue = $queue;
    }

    /**
     * Generate a token
     *
     * @return string
     */
    public function execute()
    {
        $counter = QueueCounter::available()->first();

        if(is_null($counter)) {
            return false;
        }

        $this->queue->counter_id = $counter->id;
        $this->queue->save();

        $counter->busy = true;
        $counter->save();

        return true;
    }
}