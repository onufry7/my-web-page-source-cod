<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    // The attributes that are mass assignable.
    protected $fillable = [
        'name',
        'nick',
        'email',
        'password',
    ];

    // The attributes that should be hidden for serialization.
    protected $hidden = [
        'role',
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    // The accessors to append to the model's array form.
    protected $appends = [
        'profile_photo_url',
    ];

    // The attributes that should be cast.
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getNameRole(): static|string
    {
        return UserRole::from($this->role)->label();
    }

    public function isAdmin(): bool
    {
        return $this->role == UserRole::Admin->value;
    }
}
