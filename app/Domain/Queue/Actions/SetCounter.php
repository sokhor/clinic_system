<?php

namespace Domain\Queue\Actions;

use Domain\Queue\Models\Queue;
use Domain\Queue\Models\QueueCounter;

class SetCounter
{
    /**
     * Generate a ticket
     *
     * @param \Domain\Queue\Models\Queue $queue
     * @return string
     */
    public function execute(Queue $queue)
    {
        $counter = QueueCounter::available()->first();

        if(is_null($counter)) {
            return false;
        }

        $queue->counter_id = $counter->id;
        $queue->save();

        $counter->busy = true;
        $counter->save();

        return true;
    }
}