<?php

namespace Tests\Unit;

use App\Enums\BoardGameType;
use App\View\Components\BoardGame\TypeIcon;
use PHPUnit\Framework\TestCase;

class BoardGameTypeIconTest extends TestCase
{
    public function test_it_returns_correct_label_for_base_game(): void
    {
        $category = BoardGameType::BaseGame;

        $this->assertEquals('Base game', $category->label());
    }

    public function test_it_returns_correct_label_for_expansion_game(): void
    {
        $category = BoardGameType::Expansion;

        $this->assertEquals('Expansion', $category->label());
    }

    public function test_it_returns_correct_label_for_mini_expansion(): void
    {
        $category = BoardGameType::MiniExpansion;

        $this->assertEquals('Mini expansion', $category->label());
    }

    public function test_it_sets_the_correct_icon_for_base_game(): void
    {
        $component = new TypeIcon(BoardGameType::BaseGame->value);
        $this->assertEquals('rpg-round-bottom-flask', $component->icon);
    }

    public function test_it_sets_the_correct_icon_for_expansion_game(): void
    {
        $component = new TypeIcon(BoardGameType::Expansion->value);
        $this->assertEquals('rpg-vial', $component->icon);
    }

    public function test_it_sets_the_correct_icon_for_mini_expansion(): void
    {
        $component = new TypeIcon(BoardGameType::MiniExpansion->value);
        $this->assertEquals('rpg-corked-tube', $component->icon);
    }
}
