<?php

namespace Domain\Queue\ValueObjects;

use Spatie\DataTransferObject\DataTransferObject;

class QueueCounterData extends DataTransferObject
{
    /** @var int */
    public $section_id;

    /** @var string */
    public $label;

    /** @var bool */
    public $active;

    /** @var bool */
    public $busy;

    /**
     * Create a new value object instance
     *
     * @param array $input
     */
    public function __construct(array $input)
    {
        $this->section_id = $input['section_id'];
        $this->label = $input['label'];
        $this->active = $input['active'];
        $this->busy = $input['busy'];
    }

    /**
     * Get data from array.
     *
     * @param array $input
     * @return self
     */
    public static function fromArray(array $input): self
    {
        return new self([
            'section_id' => $input['section_id'],
            'label' => $input['label'],
            'active' => $input['active'],
            'busy' => isset($input['busy']) ? $input['busy'] : false,
        ]);
    }
}
