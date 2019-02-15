<?php

namespace Domain\Queue\Actions;

use Domain\Queue\Actions\GenerateTicket;
use Domain\Queue\Models\Queue;

class CreateQueue
{
    /**
     * Generate a token
     *
     * @return string
     */
    public function execute()
    {
        $ticket = (new GenerateTicket)->execute();

        return Queue::create([
            'ticket' => $ticket,
            'status' => 0,
        ]);
    }
}