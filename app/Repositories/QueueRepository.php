<?php

namespace App\Repositories;

use App\Models\Queue;
use App\Models\Counter;

class QueueRepository
{
    /**
     * Create a new queue
     *
     * @param  Array|array $param
     * @return \App\Models\Queue
     */
    public function create(Array $param = [])
    {
        $token = $this->generateToken();

        return Queue::create([
            'token' => $token,
            'status' => 0,
        ]);
    }

    /**
     * Generate a token
     *
     * @return string
     */
    private function generateToken()
    {
        $queue_count = Queue::today()->count();

        return 'A' . sprintf("%'.03d", ++$queue_count);
    }

    /**
     * Set counter
     *
     * @param \App\Models\Queue $queue
     */
    public function setCounter(Queue $queue)
    {
        $counter = Counter::available()->first();

        if(is_null($counter)) {
            return false;
        }

        $queue->counter_id = $counter->id;
        $queue->save();

        $counter->available = false;
        $counter->save();

        return true;
    }
}