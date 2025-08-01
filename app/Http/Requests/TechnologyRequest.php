<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class TechnologyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('isAdmin');
    }

    public function rules(): array
    {
        return [
            'name' => [
                Rule::when(request()->isMethod('put'), Rule::unique('technologies')->ignore($this->technology)),
                Rule::when(request()->isMethod('post'), 'unique:technologies,name'),
                'required',
                'min:3',
                'max:60',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('Technology name'),
        ];
    }
}
