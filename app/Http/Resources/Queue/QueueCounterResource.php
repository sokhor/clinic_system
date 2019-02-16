<?php

namespace App\Http\Resources\Queue;

use Illuminate\Http\Resources\Json\JsonResource;

class QueueCounterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'active' => $this->active,
            'busy' => $this->busy,
        ];
    }
}
