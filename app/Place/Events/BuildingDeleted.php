<?php

namespace App\Place\Events;

use Illuminate\Queue\SerializesModels;
use App\Place\Models\Building;

class BuildingDeleted
{
    use SerializesModels;

    /**
     * Building model
     *
     * @var \App\Place\Models\Building
     */
    public $building;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Building $building)
    {
        $this->building = $building;
    }
}
