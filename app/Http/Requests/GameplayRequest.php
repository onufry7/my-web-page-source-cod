<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;

class GameplayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return request()->isMethod('post')
            ? Gate::allows('isUser') || Gate::allows('isAdmin')
            : auth()->id() == $this->user_id || Gate::allows('isAdmin');
    }

    public function rules(): array
    {
        return [
            'board_game_id' => 'required|exists:board_games,id',
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date_format:Y-m-d',
            'count' => 'required|integer|numeric|min:1|max:200',
        ];
    }

    public function attributes(): array
    {
        return [
            'board_game_id' => __('Game name'),
            'count' => __('Number of gameplays'),
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'date' => is_string($this->date) ? Carbon::parse($this->date)->format('Y-m-d') : $this->date,
        ]);
    }
}
