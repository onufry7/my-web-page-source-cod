<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Gameplay extends Model
{
    use HasFactory;

    protected $fillable = ['board_game_id', 'user_id', 'date', 'count'];

    public function boardGame(): BelongsTo
    {
        return $this->belongsTo(BoardGame::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function dateForForm(string $format = 'Y-m-d'): string
    {
        return is_string($this->attributes['date']) ? Carbon::parse($this->attributes['date'])->format($format) : '';
    }

    protected function date(): Attribute
    {
        return Attribute::make(
            get: fn () => is_string($this->attributes['date']) ? Carbon::parse($this->attributes['date'])->format('d-m-Y') : $this->attributes['date'],
            set: fn (string $value) => Carbon::parse($value)->format('Y-m-d'),
        );
    }
}
