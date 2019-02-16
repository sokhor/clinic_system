<?php

namespace App\Http\Resources\Queue;

use App\Http\Resources\Queue\QueueSectionResource;
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
            'section_id' => $this->section_id,
            'section' => new QueueSectionResource($this->whenLoaded('section')),
        ];
    }
}
