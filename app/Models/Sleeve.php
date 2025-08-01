<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sleeve extends Model
{
    use HasFactory;

    protected $fillable = ['mark', 'name', 'height', 'width', 'thickness', 'image_path', 'quantity_available'];
    protected $casts = ['height' => 'integer', 'width' => 'integer', 'thickness' => 'integer', 'quantity_available' => 'integer'];

    public function boardGames(): BelongsToMany
    {
        return $this->belongsToMany(BoardGame::class)->withPivot('quantity');
    }

    public function correctSleeves(): HasMany
    {
        return $this->hasMany(CorrectSleeve::class);
    }

    public function getFullName(): string
    {
        return $this->mark . ' - ' . $this->name;
    }

    public function getSize(): string
    {
        return $this->width . 'x' . $this->height . ' mm';
    }

    public function getQuantityAvailable(): int
    {
        return is_null($this->quantity_available) ? 0 : $this->quantity_available;
    }
}
