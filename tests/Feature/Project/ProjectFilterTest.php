<?php

namespace Tests\Feature\Project;

use App\Enums\ProjectCategory;
use App\Models\Project;

class ProjectFilterTest extends ProjectTestCase
{
    public function test_project_category_filter_is_correct(): void
    {
        Project::create([
            'name' => 'Dog',
            'slug' => 'dog',
            'url' => 'http://google.com',
            'git' => 'http://google.com',
            'category' => ProjectCategory::Ciphers->value,
        ]);

        Project::create([
            'name' => 'Cat',
            'slug' => 'cat',
            'url' => 'http://google.com',
            'git' => 'http://google.com',
            'category' => ProjectCategory::Others->value,
        ]);

        $route = route($this->routeIndex, ['kategoria' => 'ciphers']);

        $response = $this->get($route);

        $response->assertStatus(200)
            ->assertSeeText('Dog')
            ->assertDontSeeText('Cat')
            ->assertDontSeeText(__('No projects'));
    }

    public function test_project_category_filter_is_incorrect(): void
    {
        Project::create([
            'name' => 'Dog',
            'slug' => 'dog',
            'url' => 'http://google.com',
            'git' => 'http://google.com',
            'category' => ProjectCategory::Ciphers->value,
        ]);

        Project::create([
            'name' => 'Cat',
            'slug' => 'cat',
            'url' => 'http://google.com',
            'git' => 'http://google.com',
            'category' => ProjectCategory::Others->value,
        ]);

        $route = route($this->routeIndex, ['kategoria' => 'test']);

        $response = $this->get($route);

        $response->assertStatus(200)
            ->assertSeeText(__('No projects'))
            ->assertDontSeeText('Dog')
            ->assertDontSeeText('Cat');
    }

    public function test_project_category_filter_is_empty(): void
    {
        Project::create([
            'name' => 'Dog',
            'slug' => 'dog',
            'url' => 'http://google.com',
            'git' => 'http://google.com',
            'category' => ProjectCategory::Ciphers->value,
        ]);

        Project::create([
            'name' => 'Cat',
            'slug' => 'cat',
            'url' => 'http://google.com',
            'git' => 'http://google.com',
            'category' => ProjectCategory::Others->value,
        ]);

        $route = route($this->routeIndex, ['kategoria' => '']);

        $response = $this->get($route);

        $response->assertStatus(200)
            ->assertDontSeeText(__('No projects'))
            ->assertSeeText('Dog')
            ->assertSeeText('Cat');
    }

    public function test_project_name_filter_is_correct(): void
    {
        Project::create([
            'name' => 'Dog',
            'slug' => 'dog',
            'url' => 'http://google.com',
            'git' => 'http://google.com',
            'category' => ProjectCategory::Ciphers->value,
        ]);

        Project::create([
            'name' => 'Dog 2',
            'slug' => 'dog-2',
            'url' => 'http://google.com',
            'git' => 'http://google.com',
            'category' => ProjectCategory::Others->value,
        ]);

        Project::create([
            'name' => 'Cat',
            'slug' => 'cat',
            'url' => 'http://google.com',
            'git' => 'http://google.com',
            'category' => ProjectCategory::Others->value,
        ]);

        $route = route($this->routeIndex, ['nazwa' => 'Dog']);

        $response = $this->get($route);

        $response->assertStatus(200)
            ->assertSeeText('Dog')
            ->assertSeeText('Dog 2')
            ->assertDontSeeText('Cat')
            ->assertDontSeeText(__('No projects'));
    }

    public function test_project_name_filter_is_incorrect(): void
    {
        Project::create([
            'name' => 'Dog',
            'slug' => 'dog',
            'url' => 'http://google.com',
            'git' => 'http://google.com',
            'category' => ProjectCategory::Ciphers->value,
        ]);

        Project::create([
            'name' => 'Cat',
            'slug' => 'cat',
            'url' => 'http://google.com',
            'git' => 'http://google.com',
            'category' => ProjectCategory::Others->value,
        ]);

        $route = route($this->routeIndex, ['nazwa' => 'xyz']);

        $response = $this->get($route);

        $response->assertStatus(200)
            ->assertDontSeeText('Dog')
            ->assertDontSeeText('Cat')
            ->assertSeeText(__('No projects'));
    }

    public function test_project_name_filter_is_empty(): void
    {
        Project::create([
            'name' => 'Dog',
            'slug' => 'dog',
            'url' => 'http://google.com',
            'git' => 'http://google.com',
            'category' => ProjectCategory::Ciphers->value,
        ]);

        Project::create([
            'name' => 'Dog 2',
            'slug' => 'dog-2',
            'url' => 'http://google.com',
            'git' => 'http://google.com',
            'category' => ProjectCategory::Others->value,
        ]);

        Project::create([
            'name' => 'Cat',
            'slug' => 'cat',
            'url' => 'http://google.com',
            'git' => 'http://google.com',
            'category' => ProjectCategory::Others->value,
        ]);

        $route = route($this->routeIndex, ['nazwa' => '']);

        $response = $this->get($route);

        $response->assertStatus(200)
            ->assertSeeText('Dog')
            ->assertSeeText('Dog 2')
            ->assertSeeText('Cat')
            ->assertDontSeeText(__('No projects'));
    }
}
