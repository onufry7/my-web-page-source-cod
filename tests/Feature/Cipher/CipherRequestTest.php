<?php

namespace Tests\Feature\Cipher;

use App\Http\Requests\CipherRequest;
use App\Models\Cipher;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;

class CipherRequestTest extends CipherTestCase
{
    // Unique Fields
    public function test_cipher_name_field_is_unique_on_created(): void
    {
        Cipher::factory()->create(['name' => 'Name', 'slug' => 'name']);
        $newCipher = Cipher::factory()->make([
            'name' => 'Name',
            'slug' => 'name',
        ])->toArray();
        $route = route($this->routeStore);

        $response = $this->actingAs($this->admin)->post($route, $newCipher);

        $response->assertStatus(302)->assertSessionHasErrors(['name', 'slug']);
    }

    public function test_cipher_name_field_is_unique_on_updated(): void
    {
        Cipher::factory()->create(['name' => 'Name', 'slug' => 'name']);
        $cipherToUpdate = Cipher::factory()->create([
            'name' => 'Other Name',
            'slug' => 'other-name',
        ]);
        $route = route($this->routeUpdate, $cipherToUpdate);

        $response = $this->actingAs($this->admin)->put($route, [
            'name' => 'Name',
            'slug' => 'name',
        ]);

        $response->assertStatus(302)->assertSessionHasErrors(['name', 'slug']);
    }

    public function test_cipher_name_unique_is_ignored_on_update_for_current_cipher(): void
    {
        $cipher = Cipher::factory()->create();
        $route = route($this->routeUpdate, $cipher);

        $response = $this->actingAs($this->admin)->put($route, $cipher->toArray());

        $response->assertStatus(302)->assertSessionHasNoErrors();
    }

    #[DataProvider('validProvider')]
    public function test_field_validation_passed(array $data): void
    {
        $request = new CipherRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes(), 'Validation failed for valid data: ' . var_export($data, true));
    }

    #[DataProvider('invalidProvider')]
    public function test_field_validation_failed(array $data): void
    {
        $request = new CipherRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes(), 'Validation passed for invalid data: ' . var_export($data, true));
    }

    // Providers
    public static function validProvider(): array
    {
        $file = UploadedFile::fake()->create('template.htm')->size(100);
        $cover = UploadedFile::fake()->image('cover.png', 20, 20)->size(400);

        return [
            'All fields correct' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'sub_name' => 'Correct sub name',
                'file' => $file,
            ]],

            'Empty sub name' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'sub_name' => '',
                'file' => $file,
            ]],

            'Cover correct' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'sub_name' => '',
                'cover_image' => $cover,
            ]],
        ];
    }

    public static function invalidProvider(): array
    {
        $file = UploadedFile::fake()->create('template.htm')->size(100);
        $largeFile = UploadedFile::fake()->create('template.htm')->size(201);
        $largeCover = UploadedFile::fake()->image('cover.png', 20, 20)->size(4097);

        return [
            'Too long name' => [[
                'name' => str_repeat('a', 101),
                'slug' => 'correct-name',
                'sub_name' => 'Correct sub name',
                'file' => $file,
            ]],

            'Empty name' => [[
                'name' => '',
                'slug' => 'correct-name',
                'sub_name' => 'Correct sub name',
                'file' => $file,
            ]],

            'Too long sub name' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'sub_name' => str_repeat('a', 101),
                'file' => $file,
            ]],

            'File is to large' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'sub_name' => 'Correct sub name',
                'file' => $largeFile,
            ]],

            'Cover image is to large' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'sub_name' => 'Correct sub name',
                'cover_image' => $largeCover,
            ]],

            'Cover image have incorrect extension' => [[
                'name' => 'Correct name',
                'slug' => 'correct-name',
                'sub_name' => 'Correct sub name',
                'cover_image' => $file,
            ]],
        ];
    }
}
