<?php

namespace Domain\Queue\Actions;

use Domain\Queue\Models\QueueSection;

class QueueSectionDestroy
{
    /**
     * Delete a queue section
     *
     * @param   int $id
     * @return \Domain\Queue\Models\QueueSection
     */
    public function execute($id)
    {
        $section = QueueSection::findOrFail($id);

        $section->delete();

        return $section;
    }
}