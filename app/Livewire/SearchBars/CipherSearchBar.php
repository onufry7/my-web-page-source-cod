<?php

namespace App\Livewire\SearchBars;

use App\Models\Cipher;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CipherSearchBar extends Component
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
            $this->records = Cipher::where('name', 'like', DB::raw('?'))->orWhere('sub_name', 'like', DB::raw('?'))
                ->setBindings([$search, $search])->get();
        }
    }

    public function render(): View
    {
        return view('livewire.search-bar', ['model' => 'cipher']);
    }
}
