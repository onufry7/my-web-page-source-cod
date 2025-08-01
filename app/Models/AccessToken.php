<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class AccessToken extends Model
{
    use HasFactory;

    protected $fillable = ['token', 'url', 'expires_at', 'is_used', 'email'];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime:Y-m-d H:i',
            'is_used' => 'boolean',
        ];
    }

    public static function generateToken(): string
    {
        return Str::uuid();
    }

    public function isExpired(): bool
    {
        return Carbon::parse($this->expires_at)->isPast();
    }

    public function isActive(): bool
    {
        return !$this->isExpired() && !$this->is_used;
    }

    public function markAsUsed(): void
    {
        $this->update(['is_used' => true]);
    }
}
