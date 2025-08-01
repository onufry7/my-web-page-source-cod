<?php

namespace Tests\Feature\Technology;

use App\Http\Requests\TechnologyRequest;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class TechnologyRequestTest extends TestCase
{
    #[DataProvider('provideNameValid')]
    public function test_name_valid(array $data): void
    {
        $request = new TechnologyRequest();

        $validator = Validator::make($data, $request->rules());

        self::assertTrue($validator->passes(), 'Validation failed for valid data: ' . var_export($data, true));
    }

    #[DataProvider('provideNameInvalid')]
    public function test_name_validation_failed(array $data): void
    {
        $request = new TechnologyRequest();

        $validator = Validator::make($data, $request->rules());

        self::assertFalse($validator->passes(), 'Validation passed for invalid data: ' . var_export($data, true));
    }

    // Providers
    public static function provideNameValid(): array
    {
        return [
            'name has minimum length' => [['name' => 'abc']],
            'name has middle length' => [['name' => str_repeat('a', 30)]],
            'name has maximum length' => [['name' => str_repeat('a', 60)]],
        ];
    }

    public static function provideNameInvalid(): array
    {
        return [
            'name is empty' => [['name' => '']],
            'name is too short length' => [['name' => 'ab']],
            'name is too long length' => [['name' => str_repeat('a', 61)]],
        ];
    }
}
