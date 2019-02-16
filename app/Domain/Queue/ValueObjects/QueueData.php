<?php

namespace Domain\Queue\ValueObjects;

use Spatie\DataTransferObject\DataTransferObject;

class QueueData extends DataTransferObject
{
    /** @var int */
    public $section_id;


    /**
     * Create a new value object instance
     *
     * @param string $name
     * @param bool   $active
     */
    public function __construct(int $section_id)
    {
        $this->section_id = $section_id;
    }

    /**
     * Get data from array.
     *
     * @param array $input
     * @return self
     */
    public static function fromArray(array $input): self
    {
        return new self(
            $input['section_id']
        );
    }
}