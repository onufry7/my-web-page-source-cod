<?php

namespace App\Models;

use App\Filters\CipherFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cipher extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'sub_name', 'slug', 'content', 'cover'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getSubNameInBrackets(): string
    {
        return $this->sub_name ? "($this->sub_name)" : '';
    }

    public function scopeFilter(Builder $query, CipherFilter $filters): Builder
    {
        return $filters->apply($query);
    }
}
