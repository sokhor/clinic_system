<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class AppointmentResource extends JsonResource
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
            'subject' => $this->subject,
            'appointed_at' => Carbon::createFromFormat('Y-m-d H:i:s', $this->appointed_at)->format(config('app.timestamp_format')),
            'comment' => $this->comment,
            'doctor_id' => $this->doctor_id,
            'status' => $this->status,
            'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format(config('app.timestamp_format')),
            'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->format(config('app.timestamp_format')),
        ];
    }
}
