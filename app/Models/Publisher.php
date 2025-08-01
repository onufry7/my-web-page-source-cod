<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Publisher extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'website'];
    public $timestamps = false;

    public function originalBoardGames(): HasMany
    {
        return $this->hasMany(BoardGame::class, 'original_publisher_id', 'id');
    }

    public function publishBoardGames(): HasMany
    {
        return $this->hasMany(BoardGame::class, 'publisher_id', 'id');
    }

    public function getBoardGames(): Collection
    {
        return $this->originalBoardGames->merge($this->publishBoardGames)->unique();
    }
}
