<?php

namespace Tests\Unit;

use App\Enums\ProjectCategory;
use App\Models\Project;
use App\View\Components\Project\CategoryIcon;
use PHPUnit\Framework\TestCase;

class ProjectCategoryTest extends TestCase
{
    public function test_it_returns_correct_label_for_coding(): void
    {
        $category = ProjectCategory::Coding;

        $this->assertEquals('Coding', $category->label());
    }

    public function test_it_returns_correct_label_for_games(): void
    {
        $category = ProjectCategory::Games;

        $this->assertEquals('Board games', $category->label());
    }

    public function test_it_returns_correct_label_for_ciphers(): void
    {
        $category = ProjectCategory::Ciphers;

        $this->assertEquals('Ciphers', $category->label());
    }

    public function test_it_returns_correct_label_for_others(): void
    {
        $category = ProjectCategory::Others;

        $this->assertEquals('Others', $category->label());
    }

    public function test_it_sets_the_correct_icon_for_coding_category(): void
    {
        $component = new CategoryIcon(ProjectCategory::Coding->value);
        $this->assertEquals('rpg-scroll-unfurled', $component->icon);
    }

    public function test_it_sets_the_correct_icon_for_ciphers_category(): void
    {
        $component = new CategoryIcon(ProjectCategory::Ciphers->value);
        $this->assertEquals('rpg-rune-stone', $component->icon);
    }

    public function test_it_sets_the_correct_icon_for_games_category(): void
    {
        $component = new CategoryIcon(ProjectCategory::Games->value);
        $this->assertEquals('rpg-pawn', $component->icon);
    }

    public function test_it_sets_the_default_icon_for_unknown_category(): void
    {
        $component = new CategoryIcon('unknown-category');
        $this->assertEquals('rpg-diamond', $component->icon);
    }

    public function test_get_name_category_returns_label_for_valid_category(): void
    {
        $project = new Project();
        $project->category = ProjectCategory::Ciphers->value;

        $this->assertEquals(ProjectCategory::Ciphers->label(), $project->getNameCategory());
    }

    public function test_get_name_category_returns_empty_string_when_category_is_empty(): void
    {
        $project = new Project();
        $project->category = null;

        $this->assertEquals('', $project->getNameCategory());
    }
}
