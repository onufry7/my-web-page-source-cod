<?php

namespace App\Http\Requests;

use App\Enums\ProjectCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class ProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('isAdmin');
    }

    public function rules(): array
    {
        return [
            'name' => [
                Rule::when(request()->isMethod('put'), Rule::unique('projects')->ignore($this->project)),
                Rule::when(request()->isMethod('post'), 'unique:projects,name'),
                'required',
                'string',
                'min:3',
                'max:160',
            ],

            'slug' => [
                Rule::when(request()->isMethod('put'), Rule::unique('projects')->ignore($this->project)),
                Rule::when(request()->isMethod('post'), 'unique:projects,slug'),
                'required',
                'string',
                'max:200',
            ],

            'url' => [
                'required',
                'max:255',
                'active_url',
            ],

            'git' => [
                'nullable',
                'max:255',
                'active_url',
            ],

            'category' => [
                'required',
                new Enum(ProjectCategory::class),
            ],

            'image' => [
                'nullable',
                'file',
                'image',
                'mimes:png,jpg,webp',
                'max:4096',
            ],

            'image_path' => [
                'nullable',
                'max:255',
            ],

            'delete_image' => [
                'nullable',
            ],

            'description' => [
                'nullable',
                'string',
                'max:4500',
            ],

            'for_registered' => [
                'boolean',
            ],

            'technologies' => [
                'nullable',
                'array',
                'min:1',
            ],

            'technologies.*' => [
                'sometimes',
                'exists:technologies,id',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('Project name'),
            'url' => __('Link to project'),
            'image' => __('Project image'),
            'git' => __('Link to GIT'),
            'delete_image' => __('Delete current image'),
        ];
    }

    protected function prepareForValidation(): void
    {
        $name = (is_string($this->name)) ? Str::slug($this->name, '-', 'pl') : null;

        $this->merge([
            'slug' => $name,
            'category' => $this->category ?? ProjectCategory::Others->value,
            'for_registered' => (bool) $this->for_registered,
        ]);
    }
}
