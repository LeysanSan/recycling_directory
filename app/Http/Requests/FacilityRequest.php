<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacilityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'business_name'   => ['required', 'string', 'max:255'],
            'last_update_date' => ['required', 'date'],
            'street_address'  => ['required', 'string', 'max:255'],
            'materials' => ['nullable', 'array'],
            'materials.*' => ['exists:materials,id'],
        ];
    }
}
