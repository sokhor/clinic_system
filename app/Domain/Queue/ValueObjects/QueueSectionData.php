<?php

namespace Domain\Queue\ValueObjects;

use Domain\Queue\Enums\QueueSectionStatus;
use Spatie\DataTransferObject\DataTransferObject;

class QueueSectionData extends DataTransferObject
{
    /** @var string */
    public $name;

    /** @var QueueSectionStatus */
    public $active;

    /**
     * Create a new value object instance
     *
     * @param string $name
     * @param QueueSectionStatus   $active
     */
    public function __construct(string $name, QueueSectionStatus $active)
    {
        $this->name = $name;
        $this->active = $active;
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
            $input['name'],
            isset($input['active']) ? new QueueSectionStatus($input['active']) : QueueSectionStatus::INACTIVE
        );
    }
}