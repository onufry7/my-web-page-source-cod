<?php

namespace App\View\Components\Project;

use App\Enums\ProjectCategory;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CategoryIcon extends Component
{
    public string $icon;

    public function __construct(string $dataCategory)
    {
        switch ($dataCategory) {
            case ProjectCategory::Coding->value:
                $this->icon = 'rpg-scroll-unfurled';
                break;

            case ProjectCategory::Ciphers->value:
                $this->icon = 'rpg-rune-stone';
                break;

            case ProjectCategory::Games->value:
                $this->icon = 'rpg-pawn';
                break;

            default:
                $this->icon = 'rpg-diamond';
                break;
        }
    }

    public function render(): Closure|string|View
    {
        return view('components.icon', ['icon' => $this->icon]);
    }
}
