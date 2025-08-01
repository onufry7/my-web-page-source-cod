<?php

namespace App\Http\Controllers\Fortify;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\ConfirmPasswordViewResponse;
use Laravel\Fortify\Contracts\PasswordConfirmedResponse;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;

class CustomConfirmablePasswordController extends ConfirmablePasswordController
{
    public function show(Request $request): ConfirmPasswordViewResponse
    {
        if (!$request->session()->has('url.before_confirm')) {
            $request->session()->put('url.before_confirm', url()->previous());
        }

        return parent::show($request);
    }

    public function store(Request $request): RedirectResponse|Responsable
    {
        $response = parent::store($request);

        if ($response instanceof PasswordConfirmedResponse) {
            session()->forget('url.before_confirm');
        }

        return $response;
    }

    public function back(Request $request): RedirectResponse
    {
        $backUrl = $request->session()->pull('url.before_confirm', route('home'));

        if (!is_string($backUrl) || $backUrl === '') {
            $backUrl = route('home');
        }

        return redirect()->to($backUrl);
    }
}
