<?php

namespace Domain\Queue\Actions;

use Domain\Queue\Models\Queue;

class GenerateTicket
{
    /**
     * Generate a token
     *
     * @return string
     */
    public function execute()
    {
        $queue_count = Queue::today()->count();

        return sprintf("%'.02d", ++$queue_count);
    }
}
