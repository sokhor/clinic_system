<?php

namespace Domain\Queue\Enums;

use MyCLabs\Enum\Enum;

class QueueSectionStatus extends Enum
{
    private const INACTIVE = false;
    private const ACTIVE = true;
}