<?php

namespace Domain\Queue\Actions;

use Domain\Queue\Models\QueueSection;
use Domain\Queue\ValueObjects\QueueSectionData;

class QueueSectionUpdate
{
    /**
     * Create a new queue section
     *
     * @param   int $id
     * @param  \Domain\Queue\ValueObjects\QueueSectionData  $input_data
     * @return \Domain\Queue\Models\QueueSection
     */
    public function execute($id, QueueSectionData $input_data)
    {
        $section = QueueSection::findOrFail($id);

        $section->name = $input_data->name;
        $section->active = $input_data->active->getValue();

        $section->save();

        return $section;
    }
}