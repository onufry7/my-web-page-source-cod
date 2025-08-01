<?php

namespace Tests\Feature\Project;

use App\Enums\ProjectCategory;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;

class ProjectRequestTest extends ProjectTestCase
{
    // Unique Fields
    public function test_project_name_field_is_unique_on_created(): void
    {
        Project::factory(1)->create(['name' => 'Name', 'slug' => 'name']);
        $newProject = Project::factory(1)->make([
            'name' => 'Name',
            'slug' => 'name',
        ])->first()->toArray();
        $route = route($this->routeStore);

        $response = $this->actingAs($this->admin)->post($route, $newProject);

        $response->assertStatus(302)->assertSessionHasErrors(['name', 'slug']);
    }

    public function test_project_name_field_is_unique_on_updated(): void
    {
        Project::factory(1)->create(['name' => 'Name', 'slug' => 'name']);
        $projectToUpdate = Project::factory(1)->create([
            'name' => 'Other Name',
            'slug' => 'other-name',
        ])->first();
        $route = route($this->routeUpdate, $projectToUpdate);

        $response = $this->actingAs($this->admin)->put($route, [
            'name' => 'Name',
            'slug' => 'name',
        ]);

        $response->assertStatus(302)->assertSessionHasErrors(['name', 'slug']);
    }

    public function test_project_name_unique_is_ignored_on_update_for_current_project(): void
    {
        $project = Project::factory(1)->create()->first();
        $route = route($this->routeUpdate, $project);

        $response = $this->actingAs($this->admin)->put($route, $project->toArray());

        $response->assertStatus(302)->assertSessionHasNoErrors();
    }

    #[DataProvider('validProvider')]
    public function test_field_validation_passed(array $data): void
    {
        $request = new ProjectRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes(), 'Validation failed for valid data: ' . var_export($data, true));
    }

    #[DataProvider('invalidProvider')]
    public function test_field_validation_failed(array $data): void
    {
        $request = new ProjectRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes(), 'Validation passed for invalid data: ' . var_export($data, true));
    }

    #[DataProvider('validImageProvider')]
    public function test_project_image_valid($data): void
    {
        $request = new ProjectRequest();

        $validator = Validator::make([
            'name' => 'Fake Name',
            'slug' => 'fake-name',
            'url' => 'http://fake.pl',
            'image' => $data['image'],
            'category' => ProjectCategory::Games,
        ], $request->rules());

        $this->assertTrue($validator->passes());
    }

    #[DataProvider('invalidImageProvider')]
    public function test_project_image_invalid($data): void
    {
        $request = new ProjectRequest();

        $validator = Validator::make([
            'name' => 'Fake Name',
            'slug' => 'fake-name',
            'url' => 'http://fake.pl',
            'image' => $data['image'],
            'category' => ProjectCategory::Games,
        ], $request->rules());

        $this->assertFalse($validator->passes());
    }

    // Providers
    public static function validProvider(): array
    {
        return [
            'All fields completed' => [[
                'name' => 'Project One',
                'slug' => 'project-one',
                'url' => 'https://example.com/project-one',
                'git' => 'https://github.com/example/project-one',
                'category' => ProjectCategory::Games,
                'description' => 'This is the description for Project One.',
            ]],

            'Only name and url fields completed' => [[
                'name' => 'Project Two',
                'slug' => 'project-two',
                'url' => 'https://example.com/project-two',
                'git' => null,
                'category' => ProjectCategory::Games,
                'description' => null,
            ]],
        ];
    }

    public static function invalidProvider(): array
    {
        return [
            'Empty name' => [
                [
                    'name' => '',
                    'slug' => '',
                    'url' => 'https://example.com',
                    'git' => 'https://github.com/example/project',
                    'category' => ProjectCategory::Games,
                    'description' => 'This is a valid project description.',
                ],
            ],

            'Too short name' => [
                [
                    'name' => 'ab',
                    'slug' => 'ab',
                    'url' => 'https://example.com',
                    'git' => 'https://github.com/example/project',
                    'category' => ProjectCategory::Games,
                    'description' => 'This is a valid project description.',
                ],
            ],

            'Too long name' => [
                [
                    'name' => str_repeat('a', 161),
                    'slug' => str_repeat('a', 161),
                    'url' => 'https://example.com',
                    'git' => 'https://github.com/example/project',
                    'category' => ProjectCategory::Games,
                    'description' => 'This is a valid project description.',
                ],
            ],

            'Empty url' => [
                [
                    'name' => 'Valid Project Name',
                    'slug' => 'valid-project-name',
                    'url' => '',
                    'git' => 'https://github.com/example/project',
                    'category' => ProjectCategory::Games,
                    'description' => 'This is a valid project description.',
                ],
            ],
            'Invalid url' => [
                [
                    'name' => 'Valid Project Name',
                    'slug' => 'valid-project-name',
                    'url' => 'invalidurl',
                    'git' => 'https://github.com/example/project',
                    'category' => ProjectCategory::Games,
                    'description' => 'This is a valid project description.',
                ],
            ],

            'Invalid git' => [
                [
                    'name' => 'Valid Project Name',
                    'slug' => 'valid-project-name',
                    'url' => 'https://example.com',
                    'git' => 'invalidurl',
                    'category' => ProjectCategory::Games,
                    'description' => 'This is a valid project description.',
                ],
            ],

            'Invalid category' => [
                [
                    'name' => 'Valid Project Name',
                    'slug' => 'valid-project-name',
                    'url' => 'https://example.com',
                    'git' => 'https://github.com/example/project',
                    'category' => 'invalid_category',
                    'description' => 'This is a valid project description.',
                ],
            ],

            'Too long description' => [
                [
                    'name' => 'Valid Project Name',
                    'slug' => 'valid-project-name',
                    'url' => 'https://example.com',
                    'git' => 'https://github.com/example/project',
                    'category' => ProjectCategory::Games,
                    'description' => str_repeat('a', 4501),
                ],
            ],

            'Technologies is not array' => [
                [
                    'name' => 'Valid Project Name',
                    'slug' => '',
                    'url' => 'https://example.com',
                    'git' => 'https://github.com/example/project',
                    'category' => ProjectCategory::Games,
                    'technologies' => 1,
                ],
            ],

            'Category is null' => [
                [
                    'name' => 'Project Two',
                    'slug' => 'project-two',
                    'url' => 'https://example.com/project-two',
                    'git' => null,
                    'category' => null,
                    'description' => null,
                ],
            ],
        ];
    }

    public static function validImageProvider(): array
    {
        return [
            'Image jpg' => [['image' => UploadedFile::fake()->image('image.jpg')]],
            'Image png' => [['image' => UploadedFile::fake()->image('image.png')]],
        ];
    }

    public static function invalidImageProvider(): array
    {
        return [
            'Image gif' => [['image' => UploadedFile::fake()->image('image.gif')]],
            'Image bmp' => [['image' => UploadedFile::fake()->image('image.bmp')]],
            'Image svg' => [['image' => UploadedFile::fake()->image('image.svg')]],
            'Image psd' => [['image' => UploadedFile::fake()->image('image.psd')]],
            'Image raw' => [['image' => UploadedFile::fake()->image('image.raw')]],
            'File pdf' => [['image' => UploadedFile::fake()->create('document.pdf')]],
            'File doc' => [['image' => UploadedFile::fake()->create('document.doc')]],
        ];
    }
}
