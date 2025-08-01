<?php

namespace App\Http\Requests;

use App\Enums\BoardGameType;
use App\Models\BoardGame;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BoardGameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('isAdmin');
    }

    public function rules(): array
    {
        return [
            'name' => [
                Rule::when(request()->isMethod('put'), Rule::unique('board_games')->ignore($this->boardGame)),
                Rule::when(request()->isMethod('post'), 'unique:board_games,name'),
                'required',
                'min:1',
                'max:255',
            ],

            'slug' => [
                Rule::when(request()->isMethod('put'), Rule::unique('board_games')->ignore($this->boardGame)),
                Rule::when(request()->isMethod('post'), 'unique:board_games,slug'),
                'required',
                'min:1',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'publisher_id' => [
                'nullable',
                'exists:publishers,id',
            ],

            'original_publisher_id' => [
                'nullable',
                'exists:publishers,id',
            ],

            'age' => [
                'nullable',
                'integer',
            ],

            'min_players' => [
                'nullable',
                'integer',
                'min:1',
                'max:125',
            ],

            'max_players' => [
                'nullable',
                'integer',
                'min:1',
                'max:125',
            ],

            'game_time' => [
                'nullable',
                'integer',
            ],

            'box_img' => [
                'nullable',
                'string',
                'max:255',
            ],

            'box_image' => [
                'nullable',
                'file',
                'image',
                'mimes:png,jpg,webp',
                'max:4096',
            ],

            'instruction' => [
                'nullable',
                'string',
                'max:255',
            ],

            'instruction_file' => [
                'nullable',
                'file',
                'mimes:pdf',
                'max:60000',
            ],

            'delete_instruction' => [
                'nullable',
            ],

            'delete_box_img' => [
                'nullable',
            ],

            'video_url' => [
                'nullable',
                'url',
                'max:255',
            ],

            'bgg_url' => [
                'nullable',
                'url',
                'max:255',
            ],

            'planszeo_url' => [
                'nullable',
                'url',
                'max:255',
            ],

            'type' => [
                'nullable',
                'in:' . implode(',', array_column(BoardGameType::cases(), 'value')),
            ],

            'base_game_id' => [
                Rule::when(
                    ($this->type !== BoardGameType::BaseGame->value && !is_null($this->type)),
                    'required|exists:board_games,id',
                    ['nullable']
                ),
            ],

            'need_instruction' => [
                'nullable',
                'boolean',
            ],

            'need_insert' => [
                'nullable',
                'boolean',
            ],

            'to_painting' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('Board game name'),
            'box_image' => __('Board game image box'),
            'base_game_id' => __('Base game'),
            'publisher_id' => __('Publisher'),
            'original_publisher_id' => __('Original publisher'),
            'instruction_file' => __('Instruction'),
            'delete_instruction' => __('Delete current instruction'),
            'delete_box_img' => __('Delete current box image'),
            'need_instruction' => __('Needed instruction'),
            'need_insert' => __('Needed insert'),
            'to_painting' => __('To painting'),
        ];
    }

    protected function prepareForValidation(): void
    {
        $name = (is_string($this->name)) ? Str::slug($this->name, '-', 'pl') : null;
        $description = (is_string($this->description)) ? Str::squish($this->description) : $this->description;

        $this->merge([
            'slug' => $name,
            'base_game_id' => ($this->type !== BoardGameType::BaseGame->value) ? $this->base_game_id : null,
            'description' => $description,
            'need_instruction' => ($this->need_instruction == 'on') ? true : false,
            'need_insert' => ($this->need_insert == 'on') ? true : false,
            'to_painting' => ($this->to_painting == 'on') ? true : false,
        ]);

        if ($this->type !== BoardGameType::BaseGame->value && request()->isMethod('post')) {
            $this->prepareValueForExpansionFromBaseGame();
        }
    }

    protected function prepareValueForExpansionFromBaseGame(): void
    {
        $baseGame = BoardGame::find($this->base_game_id);

        $this->merge([
            'original_publisher_id' => ($this->original_publisher_id != null) ? $this->original_publisher_id : $baseGame->original_publisher_id ?? null,
            'publisher_id' => ($this->publisher_id != null) ? $this->publisher_id : $baseGame->publisher_id ?? null,
            'min_players' => ($this->min_players != null) ? $this->min_players : $baseGame->min_players ?? null,
            'max_players' => ($this->max_players != null) ? $this->max_players : $baseGame->max_players ?? null,
            'game_time' => ($this->game_time != null) ? $this->game_time : $baseGame->game_time ?? null,
            'age' => ($this->age != null) ? $this->age : $baseGame->age ?? null,
        ]);
    }
}
