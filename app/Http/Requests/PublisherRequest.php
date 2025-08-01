<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class PublisherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('isAdmin');
    }

    public function rules(): array
    {
        return [
            'name' => [
                Rule::when(request()->isMethod('put'), Rule::unique('publishers')->ignore($this->publisher)),
                Rule::when(request()->isMethod('post'), 'unique:publishers,name'),
                'required',
                'min:2',
                'max:60',
            ],
            'website' => [
                'nullable',
                'max:255',
                'active_url',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('Publisher name'),
            'website' => __('Publisher website'),
        ];
    }
}
