<?php

namespace App\Livewire\SearchBars;

use App\Enums\BoardGameType;
use App\Models\BoardGame;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BoardGameSearchBar extends Component
{
    public ?string $search = null;
    public ?Collection $records = null;
    public bool $dynamicSearch = false;
    public ?string $type = null;

    private function setType(): array
    {
        return match ($this->type) {
            'wszystkie' => [
                BoardGameType::BaseGame->value,
                BoardGameType::Expansion->value,
                BoardGameType::MiniExpansion->value,
            ],
            'dodatki' => [
                BoardGameType::Expansion->value,
                BoardGameType::MiniExpansion->value,
            ],
            default => [
                BoardGameType::BaseGame->value,
            ]
        };
    }

    public function updatedSearch(): void
    {
        if (empty(mb_trim($this->search ?? ''))) {
            $this->search = null;
            $this->dynamicSearch = false;
            $this->records = null;
        } else {
            $search = '%' . $this->search . '%';
            $this->records = BoardGame::where('name', 'like', DB::raw('?'))->setBindings([$search])->whereIn('type', $this->setType())->get();
            $this->dynamicSearch = true;
        }
    }

    public function render(): View
    {
        return view('livewire.search-bar', ['model' => 'board-game']);
    }
}
