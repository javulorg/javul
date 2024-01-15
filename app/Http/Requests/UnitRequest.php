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
            'unit_name'       => 'required',
            'unit_type'        => 'required|in:0,1,2',
            'unit_category'   => 'required',
            'credibility'     => 'required',
            'country'         => 'required'
        ];
    }
}
