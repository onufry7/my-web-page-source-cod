<?php

namespace App\Models;

use App\Enums\BoardGameType;
use App\Filters\BoardGameFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;

class BoardGame extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'publisher_id',
        'original_publisher_id',
        'age',
        'min_players',
        'max_players',
        'game_time',
        'box_img',
        'instruction',
        'video_url',
        'bgg_url',
        'planszeo_url',
        'type',
        'base_game_id',
        'need_instruction',
        'need_insert',
        'to_painting',
    ];

    protected function casts(): array
    {
        return [
            'need_instruction' => 'boolean',
            'need_insert' => 'boolean',
            'to_painting' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeFilter(Builder $query, BoardGameFilter $filters): Builder
    {
        return $filters->apply($query);
    }

    public function baseGame(): BelongsTo
    {
        return $this->belongsTo(BoardGame::class);
    }

    public function expansions(): HasMany
    {
        return $this->hasMany(BoardGame::class, 'base_game_id')->orderBy('type')->orderBy('name');
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function originalPublisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function gameplays(): HasMany
    {
        return $this->hasMany(Gameplay::class);
    }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'model');
    }

    public function sleeves(): BelongsToMany
    {
        return $this->belongsToMany(Sleeve::class)->withPivot(['quantity', 'sleeved', 'id'])->orderBy('width');
    }

    public function boardGameSleeves(): HasMany
    {
        return $this->hasMany(BoardGameSleeve::class);
    }

    public function getInstructionSize(): string
    {
        if (!empty($this->instruction) && Storage::disk('public')->exists($this->instruction)) {
            $sizeInKb = Storage::disk('public')->size($this->instruction);

            return number_format(round($sizeInKb / 1024 / 1024, 2), 2, ',', '.') . ' MB';
        }

        return '0 MB';
    }

    public function getAltMinPlayersFromExpansion(): ?int
    {
        $minPlayers = $this->min_players;

        if ($this->expansions->count() > 0) {
            foreach ($this->expansions as $expansion) {
                $expansionMinPlayers = $expansion->getAttribute('min_players');

                if (is_int($expansionMinPlayers) && $expansionMinPlayers < $minPlayers) {
                    $minPlayers = $expansionMinPlayers;
                }
            }
        }

        return ($minPlayers != $this->min_players) ? $minPlayers : null;
    }

    public function getAltMaxPlayersFromExpansion(): ?int
    {
        $maxPlayers = $this->max_players;

        if ($this->expansions->count() > 0) {
            foreach ($this->expansions as $expansion) {
                $expansionMaxPlayers = $expansion->getAttribute('max_players');

                if (is_int($expansionMaxPlayers) && $expansionMaxPlayers > $maxPlayers) {
                    $maxPlayers = $expansionMaxPlayers;
                }
            }
        }

        return ($maxPlayers != $this->max_players) ? $maxPlayers : null;
    }

    public function getPlayersNumber(): string
    {
        $min = $this->min_players;
        $max = $this->max_players;

        return match (true) {
            ($min !== null && $min === $max) => (string) $min,
            ($min !== null && $max !== null) => "$min - $max",
            ($min !== null) => (string) $min,
            ($max !== null) => (string) $max,
            default => '',
        };
    }

    public function getMultimediaContent(): array
    {
        return array_filter([
            'bgg' => $this->bgg_url,
            'planszeo' => $this->planszeo_url,
            'video' => $this->video_url,
        ]);
    }

    public function getNameType(): static|string
    {
        return BoardGameType::from($this->type)->label();
    }

    public function getNeedInsert(): string
    {
        return ($this->need_insert) ? 'Yes' : 'No';
    }

    public function getNeedInstruction(): string
    {
        return ($this->need_instruction) ? 'Yes' : 'No';
    }

    public function getToPainting(): string
    {
        return ($this->to_painting) ? 'Yes' : 'No';
    }
}
