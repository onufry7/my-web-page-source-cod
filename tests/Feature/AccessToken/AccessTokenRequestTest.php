<?php

namespace Tests\Feature\AccessToken;

use App\Http\Requests\AccessTokenRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AccessTokenRequestTest extends TestCase
{
    #[DataProvider('validProvider')]
    public function test_field_validation_passed(array $data): void
    {
        $request = new AccessTokenRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes(), 'Validation failed for valid data: ' . var_export($data, true));
    }

    #[DataProvider('invalidProvider')]
    public function test_field_validation_failed(array $data): void
    {
        $request = new AccessTokenRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes(), 'Validation passed for invalid data: ' . var_export($data, true));
    }

    // Providers
    public static function validProvider(): array
    {
        return [
            'Only required fields' => [[
                'url' => 'https://youtu.be/h5ke4Ka4_mg',
                'expires_at' => Carbon::tomorrow()->format('Y-m-d H:i'),
                'email' => 'test@test.com',
            ]],

            'All correct fields' => [[
                'url' => 'https://youtu.be/h5ke4Ka4_mg',
                'expires_at' => Carbon::tomorrow()->format('Y-m-d H:i'),
                'is_used' => false,
                'email' => 'test@test.com',
            ]],

            'is_used field is true' => [[
                'url' => 'https://youtu.be/h5ke4Ka4_mg',
                'expires_at' => Carbon::tomorrow()->format('Y-m-d H:i'),
                'is_used' => true,
                'email' => 'test@test.com',
            ]],
        ];
    }

    public static function invalidProvider(): array
    {
        return [
            'Empty url' => [[
                'url' => '',
                'expires_at' => Carbon::tomorrow()->format('Y-m-d H:i'),
                'email' => 'test@test.com',
            ]],

            'Empty expires at' => [[
                'url' => 'https://youtu.be/h5ke4Ka4_mg',
                'expires_at' => '',
                'email' => 'test@test.com',
            ]],

            'Incorrect url' => [[
                'url' => 'test url',
                'expires_at' => Carbon::tomorrow()->format('Y-m-d H:i'),
                'email' => 'test@test.com',
            ]],

            'To long url' => [[
                'url' => 'https://www.example.com/products/electronics/smartphones/flagship-models/2024-edition/super-ultra-hd-8k-display-with-ai-camera-pro-max-plus-5g-version?utm_source=newsletter&utm_medium=email&utm_campaign=spring_sale_2024&ref=affiliate_code_XYZ123&color=midnight-black&storage=1TB&warranty=2-years&discount=SUMMER20&user_id=987654321&session_id=abcdef123456789&cart_token=zyxwvut54321&language=en&region=EU&currency=EUR&shipping=express',
                'expires_at' => Carbon::tomorrow()->format('Y-m-d H:i'),
                'email' => 'test@test.com',
            ]],

            'Incorrect format data for expires at' => [[
                'url' => 'https://youtu.be/h5ke4Ka4_mg',
                'expires_at' => Carbon::tomorrow()->format('d-m-Y H:i'),
                'email' => 'test@test.com',
            ]],

            'Past data for expires at' => [[
                'url' => 'https://youtu.be/h5ke4Ka4_mg',
                'expires_at' => Carbon::yesterday()->format('Y-m-d H:i'),
                'email' => 'test@test.com',
            ]],

            'Incorrect is used value' => [[
                'url' => 'https://youtu.be/h5ke4Ka4_mg',
                'expires_at' => Carbon::tomorrow()->format('Y-m-d H:i'),
                'email' => 'test@test.com',
                'is_used' => 'test',
            ]],

            'Incorrect email' => [[
                'url' => 'https://youtu.be/h5ke4Ka4_mg',
                'expires_at' => Carbon::tomorrow()->format('Y-m-d H:i'),
                'email' => 'incorrect email',
            ]],

            'Empty email' => [[
                'url' => 'https://youtu.be/h5ke4Ka4_mg',
                'expires_at' => Carbon::tomorrow()->format('Y-m-d H:i'),
                'email' => '',
            ]],
        ];
    }
}
