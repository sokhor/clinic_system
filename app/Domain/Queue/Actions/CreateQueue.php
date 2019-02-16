<?php

namespace Domain\Queue\Actions;

use Domain\Queue\Actions\GenerateTicket;
use Domain\Queue\Models\Queue;
use Domain\Queue\ValueObjects\QueueData;

class CreateQueue
{
    /**
     * Generate a token
     *
     * @return string
     */
    public function execute(QueueData $input_data)
    {
        $ticket = (new GenerateTicket)->execute();

        return Queue::create([
            'ticket' => $ticket,
            'status' => 0,
            'section_id' => $input_data->section_id,
        ]);
    }
}