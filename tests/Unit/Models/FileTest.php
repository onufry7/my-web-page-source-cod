<?php

namespace Tests\Unit\Models;

use App\Models\File;
use App\Models\Sleeve;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileTest extends TestCase
{
    public function test_get_size_returns_correct_size_in_kb(): void
    {
        Storage::fake('public');
        $filePath = 'test/file.txt';
        $fileSizeInBytes = 2048; // 2 KB

        Storage::disk('public')->put($filePath, str_repeat('a', $fileSizeInBytes));
        $model = new File(['path' => $filePath]);

        $this->assertEquals('2,00 KB', $model->getSize());
    }

    public function test_get_size_returns_correct_size_in_mb(): void
    {
        Storage::fake('public');
        $filePath = 'test/file.txt';
        $fileSizeInBytes = 1048576; // 1 MB

        Storage::disk('public')->put($filePath, str_repeat('a', $fileSizeInBytes));
        $model = new File(['path' => $filePath]);

        $this->assertEquals('1,00 MB', $model->getSize(true));
    }

    public function test_get_size_returns_zero_if_file_does_not_exist(): void
    {
        Storage::fake('public');
        $model = new File(['path' => 'non-existent-file.txt']);

        $this->assertEquals('0 KB', $model->getSize());
    }

    public function test_get_name_with_model_name_returns_concatenated_name_when_model_exists(): void
    {
        $relatedModel = new Sleeve(['name' => 'Test Model']);
        $model = new File(['name' => 'Test Name']);
        $model->setRelation('model', $relatedModel);

        $this->assertEquals('Test Model - Test Name', $model->getNameWithModelName());
    }

    public function test_get_name_with_model_name_returns_only_name_when_model_does_not_exist(): void
    {
        $model = new File(['name' => 'Test Name']);

        $this->assertEquals('Test Name', $model->getNameWithModelName());
    }

    public function test_get_name_with_model_name_returns_only_name_when_model_name_is_empty(): void
    {
        $relatedModel = new Sleeve(['name' => '']);
        $model = new File(['name' => 'Test Name']);
        $model->setRelation('model', $relatedModel);

        $this->assertEquals('Test Name', $model->getNameWithModelName());
    }
}
