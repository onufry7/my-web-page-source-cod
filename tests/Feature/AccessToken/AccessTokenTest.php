<?php

namespace Tests\Feature\AccessToken;

use App\Models\AccessToken;
use Illuminate\Support\Carbon;

class AccessTokenTest extends AccessTokenTestCase
{
    public function test_access_token_check_is_active_method(): void
    {
        $token1 = AccessToken::factory()->create([
            'expires_at' => Carbon::yesterday()->format('Y-m-d H:i'),
            'is_used' => 1,
        ]);
        $token2 = AccessToken::factory()->create([
            'expires_at' => Carbon::tomorrow()->format('Y-m-d H:i'),
            'is_used' => 0,
        ]);
        $token3 = AccessToken::factory()->create([
            'expires_at' => Carbon::yesterday()->format('Y-m-d H:i'),
            'is_used' => 0,
        ]);
        $token4 = AccessToken::factory()->create([
            'expires_at' => Carbon::tomorrow()->format('Y-m-d H:i'),
            'is_used' => 1,
        ]);

        $this->assertFalse($token1->isActive());
        $this->assertTrue($token2->isActive());
        $this->assertFalse($token3->isActive());
        $this->assertFalse($token4->isActive());
    }

    public function test_access_token_check_is_expired_method(): void
    {
        $token1 = AccessToken::factory()->create(['expires_at' => Carbon::yesterday()->format('Y-m-d H:i')]);
        $token2 = AccessToken::factory()->create(['expires_at' => Carbon::tomorrow()->format('Y-m-d H:i')]);

        $this->assertTrue($token1->isExpired());
        $this->assertFalse($token2->isExpired());
    }
}
