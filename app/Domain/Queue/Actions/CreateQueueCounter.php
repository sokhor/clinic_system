<?php

namespace Domain\Queue\Actions;

use Domain\Queue\Models\QueueCounter;
use Domain\Queue\ValueObjects\QueueCounterData;

class CreateQueueCounter
{
    /**
     * Create queue counter
     *
     * @param  \Domain\Queue\ValueObjects\QueueCounterData $input_data
     * @return \Domain\Queue\Models\QueueCounter
     */
    public function execute(QueueCounterData $input_data)
    {
        return QueueCounter::create([
            'label' => $input_data->label,
            'active' => $input_data->active,
            'busy' => $input_data->busy,
            'section_id' => $input_data->section_id,
        ]);
    }
}
