<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CipherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('isAdmin');
    }

    public function rules(): array
    {
        return [
            'name' => [
                Rule::when(request()->isMethod('put'), Rule::unique('ciphers')->ignore($this->cipher)),
                Rule::when(request()->isMethod('post'), 'unique:ciphers,name'),
                'required',
                'min:1',
                'max:100',
            ],

            'slug' => [
                Rule::when(request()->isMethod('put'), Rule::unique('ciphers')->ignore($this->cipher)),
                Rule::when(request()->isMethod('post'), 'unique:ciphers,slug'),
                'required',
                'min:1',
                'max:100',
            ],

            'sub_name' => ['nullable', 'string', 'max:100'],

            'file' => [
                Rule::when(request()->isMethod('post'), 'required'),
                'file',
                'max:200',
            ],

            'cover' => [
                'nullable',
                'string',
                'max:255',
            ],

            'cover_image' => [
                'nullable',
                'file',
                'image',
                'mimes:png,jpg,webp',
                'max:4096',
            ],

            'delete_cover' => [
                'nullable',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('Cipher name'),
            'sub_name' => __('Additional name'),
            'file' => __('File HTM'),
            'cover_image' => __('Cover image'),
            'delete_cover' => __('Delete current cover image'),
        ];
    }

    protected function prepareForValidation(): void
    {
        $name = (is_string($this->name)) ? Str::slug($this->name, '-', 'pl') : null;

        $this->merge([
            'slug' => $name,
        ]);
    }
}
