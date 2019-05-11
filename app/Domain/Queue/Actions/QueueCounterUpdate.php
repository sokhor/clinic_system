<?php

namespace Domain\Queue\Actions;

use Domain\Queue\Models\QueueCounter;
use Domain\Queue\ValueObjects\QueueCounterData;

class QueueCounterUpdate
{
    /**
     * Update queue counter
     *
     * @param  int $id
     * @param  \Domain\Queue\ValueObjects\QueueCounterData $input_data
     * @return \Domain\Queue\Models\QueueCounter
     */
    public function execute($id, QueueCounterData $input_data)
    {
        $counter = QueueCounter::findOrFail($id);

        $counter->label = $input_data->label;
        $counter->active = $input_data->active;
        $counter->busy = $input_data->busy;
        $counter->section_id = $input_data->section_id;

        $counter->save();

        return $counter;
    }
}
