<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class FileStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('isAdmin');
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:255',
                'regex:/^[a-zA-Z_ęóąśłżźćńĘÓĄŚŁŻŹĆŃ0-9\s\-]+$/',
            ],
            'model_id' => [
                'required',
                'integer',
            ],
            'model_type' => [
                'required',
                'string',
            ],
            'file' => [
                'required',
                'file',
                'mimes:pdf',
                'max:55000',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('File name'),
            'file' => __('File'),
            'model_id' => __('Model ID'),
            'model_type' => __('Model type'),
        ];
    }
}
