<?php

namespace App\Http\Resources;

use App\Http\Resources\PatientResource;
use Illuminate\Http\Resources\Json\JsonResource;

class VisitResource extends JsonResource
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
            'patient_id' => $this->patient_id,
            'type' => $this->type,
            'assigned_id' => $this->assigned_id,
            'progress' => $this->progress,
            'progress_text' => $this->progress_text,
            'status' => $this->status,
            'ipd' => $this->ipd,
            'registered_by' => $this->registered_by,
            'nursing' => $this->nursing,
            'nursing_by_id' => $this->nursing_by_id,
            'nursing_status' => $this->nursing_status,
            'doctor_visit' => $this->doctor_visit,
            'doctor_visit_by_id' => $this->doctor_visit_by_id,
            'doctor_visit_status' => $this->doctor_visit_status,
            'imaging' => $this->imaging,
            'imaging_by_id' => $this->imaging_by_id,
            'imaging_status' => $this->imaging_status,
            'dispensery' => $this->dispensery,
            'dispensery_by_id' => $this->dispensery_by_id,
            'dispensery_status' => $this->dispensery_status,
            'referal_id' => $this->referal_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'patient' => new PatientResource($this->whenLoaded('patient')),
            'duration' => $this->created_at->diffForHumans(),
        ];
    }
}
