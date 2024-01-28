<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'unit_name'           => 'required',
            'unit_type'           => 'required|in:0,1,2',
            'product_name'        => 'nullable|max:128',
            'service_name'        => 'nullable|max:128',
            'business_model'      => 'nullable|in:0,1',
            'operational_grade'   => 'nullable|max:5',
            'company'             => 'nullable|max:128',
            'scope'               => 'nullable|in:0,1,2,3',
            'unit_category'       => 'required',
            'credibility'         => 'required',
            'country'             => 'required'
        ];
    }
}
