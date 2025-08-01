<?php

namespace App\Models;

use App\Enums\ProjectCategory;
use App\Filters\ProjectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'url', 'git', 'category', 'image_path', 'description', 'for_registered'];

    protected function casts(): array
    {
        return [
            'for_registered' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function technologies(): BelongsToMany
    {
        return $this->belongsToMany(Technology::class);
    }

    public function scopeFilter(Builder $query, ProjectFilter $filters): Builder
    {
        return $filters->apply($query);
    }

    public function getNameCategory(): static|string
    {
        if (!empty($this->category)) {
            return ProjectCategory::from($this->category)->label();
        }

        return '';
    }
}
