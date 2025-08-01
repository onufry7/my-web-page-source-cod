<?php

namespace App\Http\Controllers\SingleActions;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CVUpload extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $cv = $request->validate([
            'cv' => 'required|file|mimes:pdf|min:10|max:2048',
        ]);

        $cv['cv']->storeAs('documents/cv', 'burnejko-cv.pdf', 'public');

        return redirect()->route('about')->withFragment('brand')->banner(__('CV uploaded successfully.'));
    }
}
