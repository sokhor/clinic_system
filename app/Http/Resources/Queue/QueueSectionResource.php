<?php

namespace App\Http\Resources\Queue;

use App\Http\Resources\Queue\QueueCounterResource;
use Illuminate\Http\Resources\Json\JsonResource;

class QueueSectionResource extends JsonResource
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
            'name' => $this->name,
            'active' => $this->active,
            'counters' => QueueCounterResource::collection($this->whenLoaded('counters')),
        ];
    }
}
