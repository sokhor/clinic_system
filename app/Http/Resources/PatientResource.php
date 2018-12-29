<?php

namespace App\Http\Resources;

use App\Http\Resources\VisitResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class PatientResource extends JsonResource
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
            'address' => $this->address,
            'age' => $this->age . ' ' . str_plural('yr', $this->age<=1 ? 1 : 2),
            'code' => $this->code,
            'dob' => Carbon::createFromFormat('Y-m-d', $this->dob)->format(config('app.date_format')),
            'email'=> $this->email,
            'full_name'=> $this->full_name,
            'full_name_2'=> $this->full_name_2,
            'gender' => $this->gender,
            'identity_no' => $this->identity_no,
            'identity_type' => $this->identity_type,
            'identity_type_text' => $this->identity_type_text,
            'last_visited_at' => Carbon::createFromFormat('Y-m-d H:i:s', $this->last_visited_at)->format(config('app.timestamp_format')),
            'nationality_code' => $this->nationality_code,
            'phone' => $this->phone,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'lastVisit' => new VisitResource($this->whenLoaded('lastVisit')),
        ];
    }
}
