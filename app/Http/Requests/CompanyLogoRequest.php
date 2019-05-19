<?php

namespace App\Http\Requests;

use Domain\Administration\Models\Company;
use Illuminate\Foundation\Http\FormRequest;

class CompanyLogoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('create', Company::class) || auth()->user()->can('edit', Company::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'logo' => 'image',
        ];
    }
}
