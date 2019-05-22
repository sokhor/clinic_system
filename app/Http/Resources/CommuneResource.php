<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommuneResource extends JsonResource
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
            'province_code' => $this->province_code,
            'district_id' => $this->district_id,
            'commune_en' => $this->commune_en,
            'commune_kh' => $this->commune_kh,
        ];
    }
}
