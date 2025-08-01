<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = new User();
        $user->name = 'Szymon Burnejko';
        $user->nick = 'Onufry';
        $user->email = 'onufry7@gmail.com';
        $user->email_verified_at = now();
        $user->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
        $user->role = UserRole::Admin->value;
        $user->two_factor_secret = null;
        $user->two_factor_recovery_codes = null;
        $user->remember_token = 'DVfIHtn0lT';
        $user->profile_photo_path = null;
        $user->current_team_id = null;
        $user->save();
    }
}
