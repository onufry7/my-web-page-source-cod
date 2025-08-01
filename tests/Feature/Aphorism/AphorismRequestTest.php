<?php

namespace Tests\Feature\Aphorism;

use App\Http\Requests\AphorismRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AphorismRequestTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('provideValid')]
    public function test_validation_correct(array $data): void
    {
        $request = new AphorismRequest();

        $validator = Validator::make($data, $request->rules());

        self::assertTrue($validator->passes(), 'Validation failed for valid data: ' . var_export($data, true));
    }

    #[DataProvider('provideInvalid')]
    public function test_validation_failed(array $data): void
    {
        $request = new AphorismRequest();

        $validator = Validator::make($data, $request->rules());

        self::assertFalse($validator->passes(), 'Validation passed for invalid data: ' . var_export($data, true));
    }

    // Providers
    public static function provideValid(): array
    {
        return [
            'sentence is string' => [[
                'sentence' => 'Sentence aphorism 1',
            ]],
            'author is null' => [[
                'sentence' => 'Sentence aphorism 2',
                'author' => null,
            ]],
            'author is string' => [[
                'sentence' => 'Sentence aphorism 3',
                'author' => 'T. Author',
            ]],
        ];
    }

    public static function provideInvalid(): array
    {
        return [
            'sentence is null' => [[
                'sentence' => null,
            ]],
            'sentence is not string' => [[
                'sentence' => 123,
            ]],
            'sentence is to short' => [[
                'sentence' => 'aa',
            ]],
            'sentence is to long' => [[
                'sentence' => str_repeat('a', times: 256),
            ]],
            'author is to long' => [[
                'sentence' => 'Sentence aphorism',
                'author' => str_repeat('a', times: 256),
            ]],
            'author is not string' => [[
                'sentence' => 'Sentence aphorism',
                'author' => 123,
            ]],
        ];
    }
}
