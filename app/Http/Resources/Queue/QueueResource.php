<?php

namespace App\Http\Resources\Queue;

use App\Http\Resources\Queue\QueueCounterResource;
use App\Http\Resources\Queue\QueueSectionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class QueueResource extends JsonResource
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
            'ticket' => $this->ticket,
            'counter_id' => $this->counter_id,
            'counter' => new QueueCounterResource($this->whenLoaded('counter')),
            'status' => $this->status,
            'section_id' => $this->section_id,
            'section' => new QueueSectionResource($this->whenLoaded('section')),
        ];
    }
}
