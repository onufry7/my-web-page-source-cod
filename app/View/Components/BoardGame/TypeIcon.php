<?php

namespace App\View\Components\BoardGame;

use App\Enums\BoardGameType;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TypeIcon extends Component
{
    public string $icon;

    public function __construct(string $dataType)
    {
        $this->icon = match ($dataType) {
            BoardGameType::Expansion->value => 'rpg-vial',
            BoardGameType::MiniExpansion->value => 'rpg-corked-tube',
            default => 'rpg-round-bottom-flask'
        };
    }

    public function render(): Closure|string|View
    {
        return view('components.icon', ['icon' => $this->icon]);
    }
}
