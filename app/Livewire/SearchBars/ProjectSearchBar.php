<?php

namespace App\Livewire\SearchBars;

use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ProjectSearchBar extends Component
{
    public ?string $search = null;
    public ?Collection $records = null;
    public bool $dynamicSearch = false;

    public function updatedSearch(): void
    {
        if (empty(mb_trim($this->search ?? ''))) {
            $this->search = null;
            $this->dynamicSearch = false;
            $this->records = null;
        } else {
            $search = '%' . $this->search . '%';
            $this->dynamicSearch = true;
            $this->records = Project::where('name', 'like', DB::raw('?'))->setBindings([$search])
                ->when(!Auth::check(), fn ($query) => $query->where('for_registered', 0))->get();
        }
    }

    public function render(): View
    {
        return view('livewire.search-bar', ['model' => 'project']);
    }
}
