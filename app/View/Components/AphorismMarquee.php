<?php

namespace App\View\Components;

use App\Models\Aphorism;
use Illuminate\View\Component;
use Illuminate\View\View;

class AphorismMarquee extends Component
{
    public ?Aphorism $aphorism;

    public function __construct()
    {
        $this->aphorism = Aphorism::inRandomOrder()->first();
    }

    public function render(): View
    {
        return view('components.aphorism-marquee');
    }
}
