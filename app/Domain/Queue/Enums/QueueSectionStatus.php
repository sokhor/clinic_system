<?php

namespace Domain\Queue\Enums;

use Spatie\Enum\Enum;

class QueueSectionStatus extends Enum
{
    const INACTIVE = false;
    const ACTIVE = true;
}