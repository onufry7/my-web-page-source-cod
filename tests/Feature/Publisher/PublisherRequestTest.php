<?php

namespace Tests\Feature\Publisher;

use App\Http\Requests\PublisherRequest;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PublisherRequestTest extends TestCase
{
    #[DataProvider('provideValid')]
    public function test_validation_correct(array $data): void
    {
        $request = new PublisherRequest();

        $validator = Validator::make($data, $request->rules());

        self::assertTrue($validator->passes(), 'Validation failed for valid data: ' . var_export($data, true));
    }

    #[DataProvider('provideInvalid')]
    public function test_validation_failed(array $data): void
    {
        $request = new PublisherRequest();

        $validator = Validator::make($data, $request->rules());

        self::assertFalse($validator->passes(), 'Validation passed for invalid data: ' . var_export($data, true));
    }

    // Providers
    public static function provideValid(): array
    {
        return [
            'name has minimum length' => [['name' => 'ab']],
            'name has middle length' => [['name' => str_repeat('a', 30)]],
            'name has maximum length' => [['name' => str_repeat('a', 60)]],
            'website url is empty' => [['name' => 'abc', 'website' => '']],
            'website is correct url' => [['name' => 'abc', 'website' => 'https://www.google.com']],
        ];
    }

    public static function provideInvalid(): array
    {
        return [
            'name is empty' => [['name' => '']],
            'name is too short length' => [['name' => 'a']],
            'name is too long length' => [['name' => str_repeat('a', 61)]],
            'incorrect website url' => [['name' => 'abc', 'website' => 'test url']],
        ];
    }
}
