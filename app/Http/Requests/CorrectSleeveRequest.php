<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CorrectSleeveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('isAdmin');
    }

    public function rules(): array
    {
        return [
            'description' => [
                'nullable',
                'string',
            ],
            'correct' => [
                'nullable',
                'string',
            ],
            'quantity_available' => [
                'integer',
                'min:0',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'correct' => __('Correct'),
            'description' => __('Description'),
            'quantity_available' => __('Quantity available'),
        ];
    }
}
