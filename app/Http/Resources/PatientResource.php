<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'dob' => $this->dob->format(config('app.date_format')),
            'email'=> $this->email,
            'full_name'=> $this->full_name,
            'other_name'=> $this->other_name,
            'gender' => $this->gender,
            'identity_no' => $this->identity_no,
            'identity_type' => $this->identity_type,
            'identity_type_text' => $this->identity_type_text,
            'last_visited_at' => $this->last_visited_at,
            'nationality_code' => $this->nationality_code,
            'phone' => $this->phone,
            'referal' => $this->referal,
            'registered_by' => $this->registered_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
