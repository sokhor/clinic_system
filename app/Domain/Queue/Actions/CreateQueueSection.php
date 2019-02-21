<?php

namespace Domain\Queue\Actions;

use Domain\Queue\Models\QueueSection;
use Domain\Queue\ValueObjects\QueueSectionData;

class CreateQueueSection
{
    /**
     * Create a new queue section
     *
     * @param  \Domain\Queue\ValueObjects\QueueSectionData  $input_data
     * @return \Domain\Queue\Models\QueueSection
     */
    public function execute(QueueSectionData $input_data)
    {
        $section = QueueSection::create([
            'name' => $input_data->name,
            'active' => $input_data->active->getValue(),
        ]);

        return $section;
    }
}