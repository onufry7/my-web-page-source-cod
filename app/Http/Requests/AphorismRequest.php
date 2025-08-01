<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class AphorismRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('isAdmin');
    }

    public function rules(): array
    {
        return [
            'sentence' => 'required|string|min:3|max:255',
            'author' => 'nullable|string|max:120',
        ];
    }
}
