<?php

namespace Domain\Queue\ValueObjects;

use Domain\Queue\Enums\QueueSectionStatus;
use Spatie\DataTransferObject\DataTransferObject;

class QueueSectionData extends DataTransferObject
{
    /** @var string */
    public $name;

    /** @var bool */
    public $active;


    /**
     * Create a new value object instance
     *
     * @param string $name
     * @param bool   $active
     */
    public function __construct(string $name, bool $active)
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
            isset($input['active']) ? $input['active'] : QueueSectionStatus::INACTIVE
        );
    }
}