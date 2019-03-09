<?php

namespace Domain\Queue\Actions;

use Domain\Queue\Models\QueueCounter;
use Domain\Queue\ValueObjects\QueueCounterData;

class QueueCounterDestroy
{
    /**
     * Update queue counter
     *
     * @param  int $id
     * @return \Domain\Queue\Models\QueueCounter
     */
    public function execute($id)
    {
        $counter = QueueCounter::findOrFail($id);

        return $counter->delete();
    }
}