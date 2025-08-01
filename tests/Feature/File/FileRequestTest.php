<?php

namespace Tests\Feature\File;

use App\Http\Requests\FileStoreRequest;
use App\Http\Requests\FileUpdateRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class FileRequestTest extends TestCase
{
    #[DataProvider('validStoreProvider')]
    public function test_field_store_validation_passed(array $data): void
    {
        $request = new FileStoreRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes(), 'Validation failed for valid data: ' . var_export($data, true));
    }

    #[DataProvider('invalidStoreProvider')]
    public function test_field_store_validation_failed(array $data): void
    {
        $request = new FileStoreRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes(), 'Validation passed for invalid data: ' . var_export($data, true));
    }

    #[DataProvider('validUpdateProvider')]
    public function test_field_update_validation_passed(array $data): void
    {
        $request = new FileUpdateRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes(), 'Validation failed for valid data: ' . var_export($data, true));
    }

    #[DataProvider('invalidUpdateProvider')]
    public function test_field_update_validation_failed(array $data): void
    {
        $request = new FileUpdateRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes(), 'Validation passed for invalid data: ' . var_export($data, true));
    }

    // Providers
    public static function validStoreProvider(): array
    {
        return [
            'All fields correct' => [[
                'name' => 'name',
                'file' => UploadedFile::fake()->create('file.pdf', 55000, 'application/pdf'),
                'model_id' => 1,
                'model_type' => 'App\Model\Cipher',
            ]],
        ];
    }

    public static function invalidStoreProvider(): array
    {
        $incorrectFile = UploadedFile::fake()->create('invalid_file.txt', 100, 'text/plain');
        $toLargeFile = UploadedFile::fake()->create('file.pdf', 55001, 'application/pdf');
        $file = UploadedFile::fake()->create('file.pdf', 1000, 'application/pdf');

        return [
            'Too long name' => [[
                'name' => str_repeat('a', 256),
                'file' => $file,
                'model_id' => 1,
                'model_type' => 'App\Model\Cipher',
            ]],

            'Empty name' => [[
                'name' => '',
                'file' => $file,
                'model_id' => 1,
                'model_type' => 'App\Model\Cipher',
            ]],

            'Incorrect char name' => [[
                'name' => 'name(2)',
                'file' => $file,
                'model_id' => 1,
                'model_type' => 'App\Model\Cipher',
            ]],

            'Without file' => [[
                'name' => 'name',
                'file' => null,
                'model_id' => 1,
                'model_type' => 'App\Model\Cipher',
            ]],

            'File is to large' => [[
                'name' => 'name',
                'file' => $toLargeFile,
                'model_id' => 1,
                'model_type' => 'App\Model\Cipher',
            ]],

            'File is incorrect' => [[
                'name' => 'name',
                'file' => $incorrectFile,
                'model_id' => 1,
                'model_type' => 'App\Model\Cipher',
            ]],

            'Incorrect model id' => [[
                'name' => 'name',
                'file' => $file,
                'model_id' => 'model',
                'model_type' => 'App\Model\Cipher',
            ]],

            'Empty model id' => [[
                'name' => 'name',
                'file' => $file,
                'model_id' => null,
                'model_type' => 'App\Model\Cipher',
            ]],

            'Empty model type' => [[
                'name' => 'name',
                'file' => $file,
                'model_id' => 1,
                'model_type' => null,
            ]],
        ];
    }

    public static function validUpdateProvider(): array
    {
        return [
            'Name fields correct' => [[
                'name' => 'name',
            ]],
        ];
    }

    public static function invalidUpdateProvider(): array
    {
        return [
            'Too long name' => [[
                'name' => str_repeat('a', 256),
            ]],

            'Empty name' => [[
                'name' => '',
            ]],

            'Incorrect char in name' => [[
                'name' => 'name(2)',
            ]],
        ];
    }
}
