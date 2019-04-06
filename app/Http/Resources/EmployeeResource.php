<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'name_native' => $this->name_native,
            'name_latin' => $this->name_latin,
            'born' => $this->born->format(config('app.date_format')),
            'gender' => $this->gender,
            'marital' => $this->marital,
            'emp_no' => $this->emp_no,
            'address' => $this->address,
            'position_id' => $this->position_id,
            'id_card_type' => $this->id_card_type,
            'id_card_no' => $this->id_card_no,
            'hiring_date' => $this->hiring_date->format(config('app.date_format')),
            'hiring_status' => $this->hiring_status,
        ];
    }
}
