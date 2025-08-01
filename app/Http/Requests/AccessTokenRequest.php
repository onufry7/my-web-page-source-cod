<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;

class AccessTokenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('isAdmin');
    }

    public function rules(): array
    {
        return [
            'url' => 'required|url|max:255',
            'expires_at' => 'required|after:now|date_format:Y-m-d H:i',
            'email' => 'required|string|email|max:255',
            'is_used' => 'bool',
        ];
    }

    public function attributes(): array
    {
        return [
            'expires_at' => __('Wygasa'),
            'url' => __('Link'),
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'expires_at' => is_string($this->expires_at) ? Carbon::parse($this->expires_at)->format('Y-m-d H:i') : $this->expires_at,
        ]);
    }
}
