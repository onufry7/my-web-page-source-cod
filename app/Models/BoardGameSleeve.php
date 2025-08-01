<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BoardGameSleeve extends Pivot
{
    use HasFactory;

    protected $fillable = ['board_game_id', 'sleeve_id', 'quantity', 'sleeved'];

    public function boardGame(): BelongsTo
    {
        return $this->belongsTo(BoardGame::class);
    }

    public function sleeve(): BelongsTo
    {
        return $this->belongsTo(Sleeve::class);
    }

    public function getSleeveFullName(): string
    {
        return ($this->sleeve && method_exists($this->sleeve, 'getFullName')) ? $this->sleeve->getFullName() : '';
    }
}
