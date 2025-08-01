<?php

namespace Tests\Feature\Sleeve;

use App\Http\Requests\SleeveRequest;
use App\Models\Sleeve;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;

class SleeveRequestTest extends SleeveTestCase
{
    // Unique Fields
    public function test_sleeve_mark_and_name_fields_is_unique_on_created(): void
    {
        Sleeve::factory()->create([
            'mark' => 'Mark',
            'name' => 'Name',
        ]);
        $newSleeve = Sleeve::factory()->make([
            'mark' => 'Mark',
            'name' => 'Name',
        ])->toArray();
        $route = route($this->routeStore);

        $response = $this->actingAs($this->admin)->post($route, $newSleeve);

        $response->assertStatus(302)->assertSessionHasErrors(['mark', 'name']);
    }

    public function test_sleeve_mark_and_name_fields_is_unique_on_updated(): void
    {
        Sleeve::factory()->create([
            'mark' => 'Mark',
            'name' => 'Name',
        ]);
        $sleeveToUpdate = Sleeve::factory()->create([
            'mark' => 'Mark other',
            'name' => 'Name otehr',
        ]);
        $route = route($this->routeUpdate, $sleeveToUpdate);

        $response = $this->actingAs($this->admin)->put($route, [
            'mark' => 'Mark',
            'name' => 'Name',
        ]);

        $response->assertStatus(302)->assertSessionHasErrors(['mark', 'name']);
    }

    public function test_sleeve_mark_and_name_unique_is_ignored_on_update_for_current_sleeve(): void
    {
        $sleeve = Sleeve::factory()->create([
            'mark' => 'Mark',
            'name' => 'Name',
        ]);

        $route = route($this->routeUpdate, $sleeve);

        $response = $this->actingAs($this->admin)->put($route, $sleeve->toArray());

        $response->assertStatus(302)->assertSessionHasNoErrors();
    }

    #[DataProvider('validProvider')]
    public function test_field_validation_passed(array $data): void
    {
        $request = new SleeveRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes(), 'Validation failed for valid data: ' . var_export($data, true));
    }

    #[DataProvider('invalidProvider')]
    public function test_field_validation_failed(array $data): void
    {
        $request = new SleeveRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes(), 'Validation passed for invalid data: ' . var_export($data, true));
    }

    // Providers
    public static function validProvider(): array
    {
        return [
            'Only required fields' => [[
                'mark' => 'FFG',
                'name' => 'Standard USA',
                'height' => 56,
                'width' => 87,
            ]],

            'All fields is correct' => [[
                'mark' => 'FFG',
                'name' => 'Standard USA',
                'height' => '56',
                'width' => '87',
                'thickness' => '50',
                'image_file' => UploadedFile::fake()->image('image.png', 100, 100)->size(4096),
                'quantity_available' => '100',
            ]],

            'Min quantity available is 0' => [[
                'mark' => 'FFG',
                'name' => 'Standard USA',
                'height' => '56',
                'width' => '87',
                'quantity_available' => '0',
            ]],

            'Min height is 5' => [[
                'mark' => 'FFG',
                'name' => 'Standard USA',
                'height' => '5',
                'width' => '87',
            ]],

            'Min width is 5' => [[
                'mark' => 'FFG',
                'name' => 'Standard USA',
                'height' => '56',
                'width' => '5',
            ]],

            'Min mark lenght is 2' => [[
                'mark' => 'FG',
                'name' => 'Standard USA',
                'height' => '56',
                'width' => '87',
            ]],

            'Min name lenght is 2' => [[
                'mark' => 'FFG',
                'name' => 'St',
                'height' => '56',
                'width' => '87',
            ]],

            'Max mark lenght is 150' => [[
                'mark' => str_repeat('a', 150),
                'name' => 'Standard USA',
                'height' => '56',
                'width' => '87',
            ]],

            'Max name lenght is 150' => [[
                'mark' => 'FFG',
                'name' => str_repeat('a', 150),
                'height' => '56',
                'width' => '87',
            ]],

            'Quantity available is 0' => [[
                'mark' => 'FFG',
                'name' => 'Standard USA',
                'height' => '56',
                'width' => '87',
                'quantity_available' => '0',
            ]],

            'Thickness is null' => [[
                'mark' => 'FFG',
                'name' => 'Standard USA',
                'height' => 56,
                'width' => 87,
                'thickness' => null,
            ]],
        ];
    }

    public static function invalidProvider(): array
    {
        return [
            'Mark is to short' => [[
                'mark' => 'F',
                'name' => 'Standard USA',
                'height' => '56',
                'width' => '87',
            ]],

            'Name is to short' => [[
                'mark' => 'FFG',
                'name' => 'S',
                'height' => '56',
                'width' => '87',
            ]],

            'Height is to lower' => [[
                'mark' => 'FFG',
                'name' => 'Standard USA',
                'height' => '4',
                'width' => '87',
            ]],

            'Width is to lower' => [[
                'mark' => 'FFG',
                'name' => 'Standard USA',
                'height' => '56',
                'width' => '4',
            ]],

            'Mark lenght is to long' => [[
                'mark' => str_repeat('a', 151),
                'name' => 'Standard USA',
                'height' => '56',
                'width' => '87',
            ]],

            'Name lenght is to long' => [[
                'mark' => 'FFG',
                'name' => str_repeat('a', 151),
                'height' => '56',
                'width' => '87',
            ]],

            'Height have incorrect type' => [[
                'mark' => 'FFG',
                'name' => 'Standard USA',
                'height' => 'test',
                'width' => '87',
            ]],

            'Width have incorrect type' => [[
                'mark' => 'FFG',
                'name' => 'Standard USA',
                'height' => '56',
                'width' => 'test',
            ]],

            'Mark is empty' => [[
                'mark' => '',
                'name' => 'Standard USA',
                'height' => '56',
                'width' => '87',
            ]],

            'Name is empty' => [[
                'mark' => 'FFG',
                'name' => '',
                'height' => '56',
                'width' => '87',
            ]],

            'Height is empty' => [[
                'mark' => 'FFG',
                'name' => 'Standard USA',
                'height' => '',
                'width' => '87',
            ]],

            'Width is empty' => [[
                'mark' => 'FFG',
                'name' => 'Standard USA',
                'height' => '56',
                'width' => '',
            ]],

            'Quantity available is to lower' => [[
                'mark' => 'FFG',
                'name' => 'Standard USA',
                'height' => '56',
                'width' => '87',
                'quantity_available' => '-1',
            ]],

            'Quantity available have incorrect type' => [[
                'mark' => 'FFG',
                'name' => 'Standard USA',
                'height' => '56',
                'width' => '87',
                'quantity_available' => 'test',
            ]],

            'Image have incorrect type' => [[
                'mark' => 'FFG',
                'name' => 'Standard USA',
                'height' => '56',
                'width' => '87',
                'image_file' => UploadedFile::fake()->create('image.pdf', 100, 'application/pdf'),
                'quantity_available' => '100',
            ]],

            'Image have incorrect size' => [[
                'mark' => 'FFG',
                'name' => 'Standard USA',
                'height' => '56',
                'width' => '87',
                'image_file' => UploadedFile::fake()->image('image.png', 100, 100)->size(4097),
                'quantity_available' => '100',
            ]],

            'Thickness is to small' => [[
                'mark' => 'FFG',
                'name' => 'Standard USA',
                'height' => 56,
                'width' => 87,
                'thickness' => 0,
            ]],

            'Thickness have incorrect value' => [[
                'mark' => 'FFG',
                'name' => 'Standard USA',
                'height' => 56,
                'width' => 87,
                'thickness' => 'ten',
            ]],
        ];
    }
}
