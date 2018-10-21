<?php

namespace App\Place\Listeners;

use App\Place\Events\BuildingDeleted;

class BuildingWardsPivot
{
    /**
     * Handle the event.
     *
     * @param  \App\Place\Events\BuildingDeleted  $event
     * @return void
     */
    public function handle(BuildingDeleted $event)
    {
        $event->building->wards()->detach();
    }
}
