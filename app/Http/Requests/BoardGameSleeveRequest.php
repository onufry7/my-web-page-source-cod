<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class BoardGameSleeveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('isAdmin');
    }

    public function rules(): array
    {
        return [
            'board_game_id' => [
                Rule::unique('board_game_sleeve', 'board_game_id')->where('sleeve_id', [$this->sleeve_id]),
                'required',
                'exists:board_games,id',
            ],

            'sleeve_id' => [
                Rule::unique('board_game_sleeve', 'sleeve_id')->where('board_game_id', [$this->board_game_id]),
                'required',
                'exists:sleeves,id',
            ],

            'quantity' => [
                'required',
                'integer',
                'min:0',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'sleeve_id' => __('Sleeves'),
            'quantity' => __('Quantity'),
        ];
    }

    public function messages()
    {
        return [
            'board_game_id.unique' => __('Sleeves already exists.'),
            'sleeve_id.unique' => __('Sleeves already exists.'),
        ];
    }
}
