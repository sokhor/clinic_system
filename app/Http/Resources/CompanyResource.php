<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'user_id' => $this->user_id,
            'company_name_kh' => $this->company_name_kh,
            'company_name_en' => $this->company_name_en,
            'logo' => $this->logo,
            'type_of_business' => $this->type_of_business,
            'telephone' => $this->telephone,
            'mobilephone' => $this->mobilephone,
            'email' => $this->email,
            'website' => $this->website,
            'address' => $this->address,
            'province' => $this->province,
            'postcode' => $this->postcode,
        ];
    }
}
