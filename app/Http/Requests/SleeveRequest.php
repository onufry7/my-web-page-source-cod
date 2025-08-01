<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class SleeveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('isAdmin');
    }

    public function rules(): array
    {
        return [
            'mark' => [
                Rule::when(request()->isMethod('put'), Rule::unique('sleeves', 'mark')->where('name', [$this->name])->ignore($this->sleeve)),
                Rule::when(request()->isMethod('post'), Rule::unique('sleeves', 'mark')->where('name', [$this->name])),
                Rule::when(!request()->isMethod('patch'), 'required'),
                'string',
                'min:2',
                'max:150',
            ],
            'name' => [
                Rule::when(request()->isMethod('put'), Rule::unique('sleeves', 'name')->where('mark', [$this->mark])->ignore($this->sleeve)),
                Rule::when(request()->isMethod('post'), Rule::unique('sleeves', 'name')->where('mark', [$this->mark])),
                Rule::when(!request()->isMethod('patch'), 'required'),
                'string',
                'min:2',
                'max:150',
            ],
            'height' => [
                Rule::when(!request()->isMethod('patch'), 'required'),
                'integer',
                'min:5',
            ],
            'width' => [
                Rule::when(!request()->isMethod('patch'), 'required'),
                'integer',
                'min:5',
            ],
            'thickness' => [
                'nullable',
                'integer',
                'min:1',
            ],
            'image_path' => [
                'nullable',
                'string',
                'max:255',
            ],
            'image_file' => [
                'nullable',
                'file',
                'image',
                'mimes:png,jpg,webp',
                'max:4096',
            ],
            'quantity_available' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'mark' => __('Sleeves mark'),
            'name' => __('Sleeves name'),
            'height' => __('Sleeves height'),
            'width' => __('Sleeves width'),
            'image_path' => __('Sleeves image'),
            'image_file' => __('Sleeves image'),
            'quantity_available' => __('Quantity available'),
        ];
    }

    public function messages()
    {
        return [
            'mark.unique' => __('Sleeves already exists.'),
            'name.unique' => __('Sleeves already exists.'),
        ];
    }
}
