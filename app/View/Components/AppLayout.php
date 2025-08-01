<?php

namespace App\View\Components;

use App\Helpers\HolidaysEventHelper;
use Illuminate\Support\Carbon;
use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public function render(): View
    {
        $bgClass = HolidaysEventHelper::getBackgroundClass(Carbon::today());

        return view('layouts.app', ['bgClass' => $bgClass]);
    }
}
