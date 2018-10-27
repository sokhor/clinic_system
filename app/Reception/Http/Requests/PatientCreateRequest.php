<?php

namespace App\Reception\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('create-patients');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_kh' => 'required',
            'name_en' => 'required',
            'gender' => 'required',
            'nationality_code' => 'required',
            'phone' => 'required',
            'identity_type' => 'required',
            'identity_no' => 'required',
        ];
    }
}
